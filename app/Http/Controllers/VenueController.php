<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sport')) {
            $query->where('sport', $request->sport);
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Filter by branch (Indoor/Outdoor) via facilities JSON
        if ($request->filled('branch')) {
            $query->whereJsonContains('facilities', $request->branch);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $venues = $query->where('available', true)->get();

        return view('venues.index', compact('venues'));
    }

    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }
}