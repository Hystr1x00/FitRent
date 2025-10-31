<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin 1 - King Padel
        $email1 = 'admin@kingpadel.test';
        $phone1 = '081234567891';
        
        $admin1 = User::where('email', $email1)->first();
        $existingPhone1 = User::where('phone', $phone1)->first();
        
        // If phone is used by different user
        if ($existingPhone1 && $existingPhone1->email !== $email1) {
            $this->command->warn("Phone {$phone1} already in use. Keeping existing phone for Admin 1.");
            $phone1 = $admin1 ? $admin1->phone : $phone1;
        }
        
        if (!$admin1) {
            // Check if phone is available for new user
            if ($existingPhone1 && $existingPhone1->email !== $email1) {
                // Generate unique phone
                $basePhone = '081234567891';
                $counter = 0;
                do {
                    $phone1 = $basePhone . ($counter > 0 ? $counter : '');
                    $counter++;
                    $existingPhone1 = User::where('phone', $phone1)->first();
                } while ($existingPhone1 && $counter < 10);
                
                if ($counter >= 10) {
                    $phone1 = '0812345' . rand(1000, 9999);
                }
                $this->command->warn("Using alternative phone for Admin 1: {$phone1}");
            }
            
            $admin1 = User::create([
                'name' => 'Admin King Padel',
                'email' => $email1,
                'phone' => $phone1,
                'password' => Hash::make('admin123'),
                'role' => 'field_admin',
            ]);
        } else {
            $admin1->name = 'Admin King Padel';
            $admin1->role = 'field_admin';
            $admin1->password = Hash::make('admin123');
            // Only update phone if it's not already in use by another user
            if (!$existingPhone1 || $existingPhone1->email === $email1) {
                $admin1->phone = $phone1;
            }
            $admin1->save();
        }
        
        $this->command->info('Admin 1 (King Padel) created/updated successfully!');
        $this->command->info('Email: ' . $email1);
        $this->command->info('Password: admin123');
        $this->command->info('Phone: ' . $admin1->phone);
        
        // Admin 2 - Another Admin
        $email2 = 'admin2@fitrent.test';
        $phone2 = '081234567892';
        
        $admin2 = User::where('email', $email2)->first();
        $existingPhone2 = User::where('phone', $phone2)->first();
        
        // If phone is used by different user
        if ($existingPhone2 && $existingPhone2->email !== $email2) {
            $this->command->warn("Phone {$phone2} already in use. Keeping existing phone for Admin 2.");
            $phone2 = $admin2 ? $admin2->phone : $phone2;
        }
        
        if (!$admin2) {
            // Check if phone is available for new user
            if ($existingPhone2 && $existingPhone2->email !== $email2) {
                // Generate unique phone
                $basePhone = '081234567892';
                $counter = 0;
                do {
                    $phone2 = $basePhone . ($counter > 0 ? $counter : '');
                    $counter++;
                    $existingPhone2 = User::where('phone', $phone2)->first();
                } while ($existingPhone2 && $counter < 10);
                
                if ($counter >= 10) {
                    $phone2 = '0812345' . rand(2000, 9999);
                }
                $this->command->warn("Using alternative phone for Admin 2: {$phone2}");
            }
            
            $admin2 = User::create([
                'name' => 'Admin Lapangan 2',
                'email' => $email2,
                'phone' => $phone2,
                'password' => Hash::make('admin123'),
                'role' => 'field_admin',
            ]);
        } else {
            $admin2->name = 'Admin Lapangan 2';
            $admin2->role = 'field_admin';
            $admin2->password = Hash::make('admin123');
            // Only update phone if it's not already in use by another user
            if (!$existingPhone2 || $existingPhone2->email === $email2) {
                $admin2->phone = $phone2;
            }
            $admin2->save();
        }
        
        $this->command->info('Admin 2 created/updated successfully!');
        $this->command->info('Email: ' . $email2);
        $this->command->info('Password: admin123');
        $this->command->info('Phone: ' . $admin2->phone);
        
        $this->command->info('✅ All admins seeded successfully!');
    }
}
