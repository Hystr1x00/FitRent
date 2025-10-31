<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL', 'super@fitrent.test');
        $password = env('SUPERADMIN_PASSWORD', 'superadmin123');
        $phone = env('SUPERADMIN_PHONE', '081234567890');

        // Check if user exists by email
        $user = User::where('email', $email)->first();
        
        // Check if phone is already used by another user
        $existingPhoneUser = User::where('phone', $phone)->first();
        
        // If phone is used by different user, don't change it for existing user
        if ($existingPhoneUser && $existingPhoneUser->email !== $email) {
            $this->command->warn("Phone number {$phone} already in use by another user ({$existingPhoneUser->email}). Keeping existing phone for Super Admin.");
            $phone = $user ? $user->phone : $phone; // Keep existing phone or use default
        }

        if (!$user) {
            // Check if phone is available for new user
            if ($existingPhoneUser && $existingPhoneUser->email !== $email) {
                // Generate a unique phone
                $basePhone = '081234567890';
                $counter = 0;
                do {
                    $phone = $basePhone . ($counter > 0 ? $counter : '');
                    $counter++;
                    $existingPhoneUser = User::where('phone', $phone)->first();
                } while ($existingPhoneUser && $counter < 10);
                
                if ($counter >= 10) {
                    $phone = '0812345' . rand(1000, 9999); // Fallback random phone
                }
                $this->command->warn("Using alternative phone: {$phone}");
            }
            
            $user = User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'role' => 'superadmin',
            ]);
            $this->command->info('Super Admin created successfully!');
        } else {
            // Update existing user - don't change phone if it's already set and unique
            $user->name = 'Super Admin';
            $user->role = 'superadmin';
            $user->password = Hash::make($password);
            // Only update phone if it's not already in use by another user
            if (!$existingPhoneUser || $existingPhoneUser->email === $email) {
                $user->phone = $phone;
            }
            $user->save();
            $this->command->info('Super Admin updated successfully!');
        }
        
        $this->command->info('Email: ' . $email);
        $this->command->info('Password: ' . $password);
        $this->command->info('Phone: ' . $user->phone);
    }
}


