<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Venue;
use App\Models\Booking;
use App\Models\Slot;
use App\Models\SlotParticipant;
use App\Models\BookingNote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function create(Venue $venue)
    {
        $venue->load(['courts.timeslots', 'courts.availableDates']);
        $availableDates = $venue->courts
            ->flatMap(fn($c) => $c->availableDates->pluck('date'))
            ->filter()
            ->map(fn($d) => \Carbon\Carbon::parse($d)->startOfDay())
            ->unique(fn($d) => $d->toDateString())
            ->sort()
            ->values();
        
        // Check if user has unpaid penalties
        $hasUnpaidPenalty = false;
        $unpaidPenalties = collect();
        
        if (Auth::check()) {
            $unpaidPenalties = Booking::where('user_id', Auth::id())
                ->where('return_status', 'approved')
                ->where('penalty_amount', '>', 0)
                ->whereNull('penalty_paid_at')
                ->with('slot.venue')
                ->get();
            
            $hasUnpaidPenalty = $unpaidPenalties->isNotEmpty();
        }
        
        return view('bookings.create', compact('venue', 'availableDates', 'hasUnpaidPenalty', 'unpaidPenalties'));
    }
    
    public function getBookedSlots(Request $request, Venue $venue)
    {
        $date = $request->input('date');
        
        if (!$date) {
            return response()->json(['error' => 'Date is required'], 400);
        }
        
        // Get all booked slots for this venue on the specified date
        // Now with court_id to differentiate between courts
        $bookedSlots = Slot::where('venue_id', $venue->id)
            ->whereDate('date', $date)
            ->whereIn('status', ['confirmed', 'open']) // Both private and shared bookings
            ->get()
            ->map(function($slot) {
                return [
                    'court_id' => $slot->court_id,  // Now we have court_id!
                    'time' => $slot->time,
                    'court_name' => $slot->court_name,
                ];
            })
            ->toArray();
        
        return response()->json(['booked_slots' => $bookedSlots]);
    }

    public function store(Request $request)
    {
        Log::info('🎯 BOOKING STORE CALLED', [
            'booking_type' => $request->booking_type,
            'venue_id' => $request->venue_id,
            'date' => $request->date,
            'max_participants' => $request->max_participants,
            'selections_raw' => $request->selections,
            'selections_count' => count($request->selections ?? []),
        ]);
        
        // Validate request
        try {
            $validated = $request->validate([
                'venue_id' => 'required|exists:venues,id',
                'booking_type' => 'required|in:private,shared',
                'date' => 'required|date|after_or_equal:today',
                'selections' => 'required|array|min:1',
                'selections.*' => 'required|string',
                'max_participants' => 'required_if:booking_type,shared|integer|min:2|max:20',
                'notes' => 'nullable|string|max:500',
            ]);
            
            Log::info('✅ VALIDATION PASSED', ['validated' => $validated]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ VALIDATION FAILED', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            throw $e;
        }

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }
        
        // Check if user has unpaid penalties
        $hasUnpaidPenalty = Booking::where('user_id', $user->id)
            ->where('return_status', 'approved')
            ->where('penalty_amount', '>', 0)
            ->whereNull('penalty_paid_at')
            ->exists();
        
        if ($hasUnpaidPenalty) {
            return redirect()->back()->with('error', 'Anda memiliki denda yang belum dibayar. Silakan lunasi terlebih dahulu sebelum melakukan booking baru.');
        }

        $venue = Venue::findOrFail($validated['venue_id']);
        
        // Use database transaction to ensure data consistency
        DB::beginTransaction();
        
        try {

        // Parse selections: "courtId|courtName|time|price"
        $selections = collect($request->selections)->map(function($sel) {
            $parts = explode('|', $sel);
            return [
                'court_id' => $parts[0],
                'court_name' => $parts[1] ?? '',
                'time' => $parts[2] ?? '',
                'price' => (int)($parts[3] ?? 0),
            ];
        })->unique(function($item) {
            // Remove duplicates based on court_id + time combination
            return $item['court_id'] . '|' . $item['time'];
        })->values();
        
        Log::info('📊 AFTER UNIQUE FILTER', [
            'selections_after_unique' => $selections->toArray(),
            'count_after_unique' => $selections->count()
        ]);
        
        $totalPrice = $selections->sum('price');
        $serviceFee = 5000;
        $finalTotal = $totalPrice + $serviceFee;

        // Bedakan antara SEWA PRIBADI vs OPEN SLOT
        if ($request->booking_type === 'private') {
            // ============================================
            // SEWA PRIBADI - Full court untuk tim sendiri
            // ============================================
            foreach ($selections as $sel) {
                $timeParts = explode(' - ', $sel['time']);
                $startTime = trim($timeParts[0] ?? '00:00');
                $endTime = trim($timeParts[1] ?? '00:00');
                
                // Create slot - PRIVATE: max_participants = 1 (hanya untuk booker)
            $slot = Slot::create([
                'venue_id' => $venue->id,
                'creator_id' => $user->id,
                'court_id' => $sel['court_id'],  // TAMBAHKAN court_id
                'court_name' => $sel['court_name'],  // TAMBAHKAN court_name
                'date' => $request->date,
                    'time' => $sel['time'],
                    'max_participants' => 1,  // Pribadi: hanya 1 orang/tim
                'current_participants' => 1,
                    'price_per_person' => $sel['price'], // Full price untuk booker
                    'status' => 'confirmed',
            ]);

                // Create booking record
            $booking = Booking::create([
                'user_id' => $user->id,
                    'venue_id' => $venue->id,
                'slot_id' => $slot->id,
                    'type' => 'private',
                    'date' => $request->date,
                    'time' => $sel['time'],
                    'total_price' => $sel['price'],
                'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'notes' => $request->notes,
                ]);
                
                // CATATAN: Jangan update court_timeslots karena itu adalah template untuk semua tanggal
                // Status booked/available dicek dari tabel slots berdasarkan tanggal spesifik
            }
            
        } else {
            // ============================================
            // OPEN SLOT - Buka untuk pemain lain join
            // ============================================
            Log::info('🔵 CREATING OPEN SLOT', [
                'max_participants' => $request->max_participants,
                'selections_count' => $selections->count()
            ]);
            
            foreach ($selections as $sel) {
                $timeParts = explode(' - ', $sel['time']);
                $startTime = trim($timeParts[0] ?? '00:00');
                $endTime = trim($timeParts[1] ?? '00:00');
                
                // Calculate price per person
                $maxParticipants = (int)$request->max_participants;
                $pricePerPerson = round($sel['price'] / $maxParticipants);
                $serviceFee = 5000;
                $totalPriceWithService = $pricePerPerson + $serviceFee;
                
                Log::info('💰 PRICE CALCULATION', [
                    'base_price' => $sel['price'],
                    'max_participants' => $maxParticipants,
                    'price_per_person' => $pricePerPerson,
                    'service_fee' => $serviceFee,
                    'total_with_service' => $totalPriceWithService
                ]);
                
                // Create slot - SHARED: multiple participants dapat join
            $slot = Slot::create([
                'venue_id' => $venue->id,
                'creator_id' => $user->id,
                'court_id' => $sel['court_id'],
                'court_name' => $sel['court_name'],
                'date' => $request->date,
                    'time' => $sel['time'],
                    'max_participants' => $maxParticipants,
                    'current_participants' => 1,  // Mulai dari 1 (creator)
                    'price_per_person' => $pricePerPerson,  // Harga dibagi jumlah peserta (tanpa service fee)
                    'status' => 'open',  // Status open agar orang lain bisa join
                ]);

                // Create booking record untuk creator
            $booking = Booking::create([
                'user_id' => $user->id,
                    'venue_id' => $venue->id,
                'slot_id' => $slot->id,
                    'type' => 'shared',
                    'date' => $request->date,
                    'time' => $sel['time'],
                    'total_price' => $totalPriceWithService,  // Creator bayar per person + service fee
                'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'notes' => $request->notes,
            ]);

                // Create slot participant untuk creator
            SlotParticipant::create([
                'slot_id' => $slot->id,
                'user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'amount_paid' => $totalPriceWithService,
                    'payment_status' => 'paid',
                ]);
                
                Log::info('✅ OPEN SLOT CREATED', [
                    'slot_id' => $slot->id,
                    'booking_id' => $booking->id,
                    'status' => $slot->status,
                    'current_participants' => $slot->current_participants,
                    'max_participants' => $slot->max_participants
                ]);
                
                // CATATAN: Jangan update court_timeslots karena itu adalah template untuk semua tanggal
                // Status booked/available dicek dari tabel slots berdasarkan tanggal spesifik
            }
        }

            // Buat notifikasi untuk admin jika ada catatan
            if (!empty($request->notes)) {
                foreach ($selections as $sel) {
                    BookingNote::create([
                        'booking_id' => $booking->id ?? null, // Use last booking ID
                        'user_id' => $user->id,
                        'venue_id' => $venue->id,
                        'court_name' => $sel['court_name'],
                        'message' => $request->notes,
                        'is_read' => false,
                    ]);
                }
            }

            // Commit transaction
            DB::commit();
            
            Log::info('Booking created successfully', [
                'user_id' => $user->id,
                'venue_id' => $venue->id,
                'booking_type' => $request->booking_type,
                'date' => $request->date
            ]);

            return redirect()->route('bookings.index')->with('booking_success', true);
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            Log::error('Booking creation failed', [
                'user_id' => $user->id ?? 'unknown',
                'venue_id' => $venue->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.');
        }
    }

    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your bookings.');
        }
        
        $bookings = $user->bookings()
            ->with('slot.venue')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Hitung statistik
        $totalConfirmed = $bookings->where('status', 'confirmed')->count();
        $totalPending = $bookings->where('status', 'pending')->count();
        
        // Only count UNPAID penalties
        $totalPenalty = $bookings->where('penalty_amount', '>', 0)
            ->whereNull('penalty_paid_at')
            ->sum('penalty_amount');
        
        // Ambil bookings dengan denda yang BELUM DIBAYAR
        $bookingsWithPenalty = $bookings->where('penalty_amount', '>', 0)
            ->whereNull('penalty_paid_at');

        return view('bookings.index', compact('bookings', 'totalConfirmed', 'totalPending', 'totalPenalty', 'bookingsWithPenalty'));
    }

    public function show(Booking $booking)
    {
        // Ensure the authenticated user owns the booking
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $booking->load('slot.venue', 'slot.participants', 'slot.creator');
        
        // Check if current user is the slot creator
        $isCreator = $booking->slot && $booking->slot->creator_id === Auth::id();
        
        return view('bookings.show', compact('booking', 'isCreator'));
    }

    public function submitReturn(Request $request, Booking $booking)
    {
        // Only allow the booking owner to submit return
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Load slot relationship to check creator
        $booking->load('slot');
        
        // Only slot creator can submit return
        if (!$booking->slot || $booking->slot->creator_id !== Auth::id()) {
            return back()->with('error', 'Hanya creator slot yang dapat mengembalikan lapangan.');
        }

        $request->validate([
            'return_photo' => 'required|image|max:4096',
            'return_note' => 'nullable|string|max:500',
            'returned_at' => 'required|date',
        ]);

        $path = $request->file('return_photo')->store('returns', 'public');
        $actual = Carbon::parse($request->returned_at);

        // Submit tanpa hitung denda - Admin yang akan tentukan denda
        $booking->update([
            'return_photo' => $path,
            'return_note' => $request->return_note,
            'returned_at' => $actual,
            'return_status' => 'pending',
        ]);

        Log::info('Return submitted - awaiting admin review', [
            'booking_id' => $booking->id,
            'returned_at' => $actual,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Pengembalian terkirim. Menunggu verifikasi admin untuk pengecekan denda (jika ada).');
    }

    /**
     * Process penalty payment
     */
    public function payPenalty(Booking $booking)
    {
        // Authorization check
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if there's penalty to pay
        if (!$booking->penalty_amount || $booking->penalty_amount <= 0) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Tidak ada denda yang perlu dibayar.');
        }

        // Check if already paid
        if ($booking->penalty_paid_at) {
            return redirect()->route('bookings.show', $booking)
                ->with('info', 'Denda sudah dibayar sebelumnya.');
        }

        try {
            DB::beginTransaction();

            // Mark penalty as paid
            $booking->update([
                'penalty_paid_at' => now(),
            ]);

            DB::commit();

            Log::info('Penalty paid', [
                'booking_id' => $booking->id,
                'penalty_amount' => $booking->penalty_amount,
                'paid_at' => now(),
            ]);

            return redirect()->route('bookings.index')
                ->with('success', 'Pembayaran denda berhasil! Rp ' . number_format($booking->penalty_amount, 0, ',', '.') . ' telah dibayarkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Penalty payment failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Pembayaran denda gagal. Silakan coba lagi.');
        }
    }
}