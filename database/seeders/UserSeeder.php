<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '1',
            'name' => 'Admin Desa',
            'phone_number' => '6282283534658',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'status' => 'approved',
            'role_id' => '1', // admin
            'otp_attempts' => 0
        ]);
    }
}
