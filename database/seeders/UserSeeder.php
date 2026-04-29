<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // bikin beberapa user biasa buat testing
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'nomor_hp' => '081111111111',
            'role' => 'user',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'nomor_hp' => '082222222222',
            'role' => 'user',
            'password' => Hash::make('123456'),
        ]);
    }
}
