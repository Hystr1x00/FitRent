<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Models\Venue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $courts = Court::with('venue')->latest()->paginate(12);
        $venues = Venue::orderBy('name')->get();
        return view('admin.fields.index', compact('courts', 'venues'));
    }

    public function create(Request $request)
    {
        $venues = Venue::orderBy('name')->get();
        return view('admin.fields.create', compact('venues'));
    }

    public function edit(Court $court)
    {
        $venues = Venue::orderBy('name')->get();
        return view('admin.fields.edit', compact('venues', 'court'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courts', 'public');
        }

        // Venue main image (optional)
        // Ensure venue record exists or create from form values
        $venue = null;
        if (!empty($data['venue_id'])) {
            $venue = Venue::find($data['venue_id']);
        }
        if (!$venue) {
            $venue = new Venue();
            $venue->name = $request->input('venue_name') ?: ($request->input('name') . ' Venue');
            $venue->sport = $request->input('sport');
            $venue->location = $request->input('location');
            $venue->address = $request->input('address') ?: $request->input('location');
            $venue->description = $request->input('about');
            $venue->price = $request->input('price_per_session', 0);
            $venue->rating = number_format(mt_rand(460, 490) / 100, 2);
            $venue->available = true;
            $venue->facilities = array_values($request->input('facilities', []));
        }
        if ($request->hasFile('venue_image')) {
            $venue->image = $request->file('venue_image')->store('venues', 'public');
        }
        $venue->save();
        $data['venue_id'] = $venue->id;

        // Court gallery (multiple)
        if ($request->hasFile('gallery')) {
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $paths[] = $file->store('courts/gallery', 'public');
            }
            $data['gallery'] = $paths;
        }

        $data['facilities'] = array_values($data['facilities'] ?? []);
        $data['labels'] = array_values($request->input('labels', []));
        // Available dates: from explicit list or generated range
        $dates = array_values($request->input('available_dates', []));
        $startDate = $request->input('available_start_date');
        $days = (int)$request->input('available_days', 0);
        if ($startDate && $days > 0) {
            $generated = [];
            $start = new \DateTime($startDate);
            for ($i = 0; $i < $days; $i++) {
                $generated[] = $start->format('Y-m-d');
                $start->modify('+1 day');
            }
            $dates = $generated;
        }
        $data['available_dates'] = $dates;

        // Auto-generate unique court_code
        $venue = Venue::findOrFail($data['venue_id']);
        $prefix = Str::of($venue->name)
            ->lower()
            ->replace(['-', '_'], ' ')
            ->explode(' ')
            ->filter()
            ->map(fn($w) => Str::substr(Str::slug($w, ''), 0, 2))
            ->implode('');
        $prefix = Str::substr($prefix, 0, 4) ?: 'court';
        $seq = Court::where('venue_id', $venue->id)->count() + 1;
        $code = $prefix.'-court'.$seq;
        while (Court::where('court_code', $code)->exists()) {
            $seq++;
            $code = $prefix.'-court'.$seq;
        }
        $data['court_code'] = $code;

        // Rating auto-generate if not provided
        if (!isset($data['rating'])) {
            $data['rating'] = number_format(mt_rand(460, 490) / 100, 2);
        }

        $court = Court::create($data);

        // Timeslots create
        $starts = (array)$request->input('timeslot_start', []);
        $ends = (array)$request->input('timeslot_end', []);
        $prices = (array)$request->input('timeslot_price', []);
        $statuses = (array)$request->input('timeslot_status', []);
        for ($i = 0; $i < count($starts); $i++) {
            if (!$starts[$i] || !$ends[$i] || !$prices[$i]) continue;
            $court->timeslots()->create([
                'start_time' => $starts[$i],
                'end_time' => $ends[$i],
                'price' => $prices[$i],
                'status' => $statuses[$i] ?? 'available',
            ]);
        }

        // Available dates create
        $dates = (array)$request->input('available_dates', []);
        $startDate = $request->input('available_start_date');
        $days = (int)$request->input('available_days');
        if ($startDate && $days > 0) {
            $start = new \DateTime($startDate);
            for ($i = 0; $i < $days; $i++) {
                $d = clone $start; $d->modify("+{$i} day");
                $dates[] = $d->format('Y-m-d');
            }
        }
        $dates = array_values(array_unique($dates));
        foreach ($dates as $d) {
            $court->availableDates()->create(['date' => $d]);
        }

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan');
    }

    public function update(Request $request, Court $court)
    {
        $data = $this->validateData($request, $court->id);

        if ($request->hasFile('image')) {
            if ($court->image) {
                Storage::disk('public')->delete($court->image);
            }
            $data['image'] = $request->file('image')->store('courts', 'public');
        }

        // Venue main image (optional)
        // Upsert venue on update
        $venue = null;
        if (!empty($data['venue_id'])) {
            $venue = Venue::find($data['venue_id']);
        }
        if (!$venue) {
            $venue = new Venue();
        }
        $venue->name = $request->input('venue_name') ?: ($venue->name ?? $court->venue->name ?? '');
        $venue->sport = $request->input('sport');
        $venue->location = $request->input('location');
        $venue->address = $request->input('address') ?: ($venue->address ?? $request->input('location'));
        $venue->description = $request->input('about');
        if ($venue->exists === false) {
            $venue->price = $request->input('price_per_session', 0);
            $venue->rating = number_format(mt_rand(460, 490) / 100, 2);
            $venue->available = true;
        }
        $venue->facilities = array_values($request->input('facilities', []));
        if ($request->hasFile('venue_image')) {
            $venue->image = $request->file('venue_image')->store('venues', 'public');
        }
        $venue->save();
        $data['venue_id'] = $venue->id;

        // Replace gallery if new files provided
        if ($request->hasFile('gallery')) {
            if (is_array($court->gallery)) {
                foreach ($court->gallery as $old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $paths = [];
            foreach ($request->file('gallery') as $file) {
                $paths[] = $file->store('courts/gallery', 'public');
            }
            $data['gallery'] = $paths;
        }

        $data['facilities'] = array_values($data['facilities'] ?? []);
        $data['labels'] = array_values($request->input('labels', []));
        $dates = array_values($request->input('available_dates', []));
        $startDate = $request->input('available_start_date');
        $days = (int)$request->input('available_days', 0);
        if ($startDate && $days > 0) {
            $generated = [];
            $start = new \DateTime($startDate);
            for ($i = 0; $i < $days; $i++) {
                $generated[] = $start->format('Y-m-d');
                $start->modify('+1 day');
            }
            $dates = $generated;
        }
        $data['available_dates'] = $dates;

        // Prevent changing generated code via update
        unset($data['court_code']);
        $court->update($data);

        // Replace timeslots
        $court->timeslots()->delete();
        $starts = (array)$request->input('timeslot_start', []);
        $ends = (array)$request->input('timeslot_end', []);
        $prices = (array)$request->input('timeslot_price', []);
        $statuses = (array)$request->input('timeslot_status', []);
        for ($i = 0; $i < count($starts); $i++) {
            if (!$starts[$i] || !$ends[$i] || !$prices[$i]) continue;
            $court->timeslots()->create([
                'start_time' => $starts[$i],
                'end_time' => $ends[$i],
                'price' => $prices[$i],
                'status' => $statuses[$i] ?? 'available',
            ]);
        }

        // Replace available dates
        $court->availableDates()->delete();
        $dates = (array)$request->input('available_dates', []);
        $startDate = $request->input('available_start_date');
        $days = (int)$request->input('available_days');
        if ($startDate && $days > 0) {
            $start = new \DateTime($startDate);
            for ($i = 0; $i < $days; $i++) {
                $d = clone $start; $d->modify("+{$i} day");
                $dates[] = $d->format('Y-m-d');
            }
        }
        $dates = array_values(array_unique($dates));
        foreach ($dates as $d) {
            $court->availableDates()->create(['date' => $d]);
        }

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui');
    }

    public function destroy(Court $court)
    {
        if ($court->image) {
            Storage::disk('public')->delete($court->image);
        }
        $court->delete();
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'venue_id' => ['nullable', 'exists:venues,id'],
            'sport' => ['required', 'string', 'max:100'],
            'venue_name' => ['nullable', 'string', 'max:255'],
            // court_code auto-generated; ignore input if any
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'venue_image' => ['nullable', 'image', 'max:6144'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['file', 'image', 'max:4096'],
            'about' => ['nullable', 'string'],
            'rules' => ['nullable', 'string'],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['string', 'max:100'],
            'labels' => ['nullable', 'array'],
            'labels.*' => ['string', 'max:50'],
            'refund_policy' => ['nullable', 'string'],
            'maps_url' => ['nullable', 'string', 'max:2048'],
            'location' => ['nullable', 'string', 'max:255'],
            'available_dates' => ['nullable', 'array'],
            'available_dates.*' => ['date_format:Y-m-d'],
            'available_start_date' => ['nullable', 'date'],
            'available_days' => ['nullable', 'integer', 'min:1', 'max:31'],
            'booking_duration_minutes' => ['required', 'integer', 'in:60,90,120'],
            'open_time' => ['required'],
            'close_time' => ['required'],
            'price_per_session' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:active,maintenance,inactive'],
            'timeslot_start' => ['nullable', 'array'],
            'timeslot_end' => ['nullable', 'array'],
            'timeslot_price' => ['nullable', 'array'],
            'timeslot_status' => ['nullable', 'array'],
            'available_dates' => ['nullable', 'array'],
            'available_start_date' => ['nullable', 'date'],
            'available_days' => ['nullable', 'integer', 'min:1', 'max:60'],
        ]);
    }
}


