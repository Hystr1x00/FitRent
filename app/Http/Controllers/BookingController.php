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
        return view('bookings.create', compact('venue', 'availableDates'));
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
        // Validate request
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'booking_type' => 'required|in:private,shared',
            'date' => 'required|date|after_or_equal:today',
            'selections' => 'required|array|min:1',
            'selections.*' => 'required|string',
            'max_participants' => 'required_if:booking_type,shared|integer|min:2|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
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
        });
        
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
            foreach ($selections as $sel) {
                $timeParts = explode(' - ', $sel['time']);
                $startTime = trim($timeParts[0] ?? '00:00');
                $endTime = trim($timeParts[1] ?? '00:00');
                
                // Calculate price per person
                $maxParticipants = (int)$request->max_participants;
                $pricePerPerson = round($sel['price'] / $maxParticipants);
                $serviceFee = 5000;
                $totalPriceWithService = $pricePerPerson + $serviceFee;
                
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
        
        $booking->load('slot.venue', 'slot.participants');
        return view('bookings.show', compact('booking'));
    }

    public function submitReturn(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
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