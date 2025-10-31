<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL', 'super@fitrent.test');
        $password = env('SUPERADMIN_PASSWORD', 'changeme123');

        $user = User::where('email', $email)->first();

        if (!$user) {
            User::create([
                'name' => 'Super Admin',
                'email' => $email,
                'password' => $password, // will be hashed by model cast
                'role' => 'superadmin',
            ]);
        } else {
            // ensure role is superadmin
            if ($user->role !== 'superadmin') {
                $user->role = 'superadmin';
            }
            // optionally reset password when SUPERADMIN_PASSWORD is set
            if (!empty(env('SUPERADMIN_PASSWORD'))) {
                $user->password = $password;
            }
            $user->save();
        }
    }
}


