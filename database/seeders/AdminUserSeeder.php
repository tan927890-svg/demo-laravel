<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@autox.test');
        $password = env('ADMIN_PASSWORD', 'secret123');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Site Admin',
                'password' => Hash::make($password),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $user->is_admin = true;
        $user->save();
    }
}
