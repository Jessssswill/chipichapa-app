<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // urutan seeder penting! kategori dulu baru yang lain
        $this->call([
            CategorySeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
        ]);
    }
}