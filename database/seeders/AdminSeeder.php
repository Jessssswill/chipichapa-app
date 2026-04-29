<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // bikin akun admin di tabel users, karena admin juga login lewat situ
        // admin cuma bisa dibikin lewat seeder ini, ga bisa register dari web
        User::create([
            'name' => 'Raja ChipiChapa',
            'email' => 'adminraja@gmail.com',
            'nomor_hp' => '081234567890',
            'role' => 'admin', // ini yang bedain admin sama user biasa
            'password' => Hash::make('rahasia123'),
        ]);
    }
}