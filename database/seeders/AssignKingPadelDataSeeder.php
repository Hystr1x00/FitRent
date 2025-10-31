<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
use App\Models\Court;
use Illuminate\Database\Seeder;

class AssignKingPadelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find Admin King Padel
        $adminKingPadel = User::where('email', 'admin@kingpadel.test')
            ->where('role', 'field_admin')
            ->first();

        if (!$adminKingPadel) {
            $this->command->error('Admin King Padel not found! Please run AdminSeeder first.');
            return;
        }

        $this->command->info('Assigning King Padel data to Admin: ' . $adminKingPadel->name);

        // Find venues that might be King Padel related
        // Search by name containing "King Padel", "king padel", "padel" (case insensitive)
        // Or venues with no admin assigned
        $kingPadelVenues = Venue::where(function($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%king padel%'])
                      ->orWhereRaw('LOWER(name) LIKE ?', ['%padel%']);
                })
                ->orWhereNull('admin_id');
            })
            ->get();

        $venueCount = 0;
        $courtCount = 0;

        foreach ($kingPadelVenues as $venue) {
            // Skip if venue already has different admin
            if ($venue->admin_id && $venue->admin_id !== $adminKingPadel->id) {
                $this->command->warn("Skipping venue '{$venue->name}' - already assigned to another admin (ID: {$venue->admin_id})");
                continue;
            }

            // Assign venue to Admin King Padel
            $venue->admin_id = $adminKingPadel->id;
            $venue->save();
            $venueCount++;

            $this->command->info("✓ Assigned venue: {$venue->name} (ID: {$venue->id})");

            // Assign all courts from this venue to Admin King Padel
            $courts = Court::where('venue_id', $venue->id)->get();
            
            foreach ($courts as $court) {
                // Skip if court already has different admin
                if ($court->admin_id && $court->admin_id !== $adminKingPadel->id) {
                    $this->command->warn("  - Skipping court '{$court->name}' - already assigned to another admin");
                    continue;
                }

                $court->admin_id = $adminKingPadel->id;
                $court->save();
                $courtCount++;

                $this->command->info("  ✓ Assigned court: {$court->name} (ID: {$court->id})");
            }
        }

        // Also assign any courts that might have "padel" in name but venue doesn't match
        // Or courts from venues assigned to King Padel that don't have admin_id
        $remainingCourts = Court::whereNull('admin_id')
            ->where(function($query) use ($adminKingPadel) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%king padel%'])
                      ->orWhereRaw('LOWER(name) LIKE ?', ['%padel%']);
                })
                ->orWhereHas('venue', function($q) use ($adminKingPadel) {
                    $q->where('admin_id', $adminKingPadel->id);
                });
            })
            ->get();

        foreach ($remainingCourts as $court) {
            if ($court->admin_id && $court->admin_id !== $adminKingPadel->id) {
                continue;
            }

            $court->admin_id = $adminKingPadel->id;
            $court->save();
            $courtCount++;

            $this->command->info("  ✓ Assigned standalone court: {$court->name} (ID: {$court->id})");
        }

        $this->command->info('');
        $this->command->info("✅ Assignment completed!");
        $this->command->info("   Venues assigned: {$venueCount}");
        $this->command->info("   Courts assigned: {$courtCount}");
    }
}
