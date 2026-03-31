<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //faker buat milih 1 nama acak dari daftar
            //unique buat mastiin gada kategori kembar
            'nama_kategori' => $this->faker->unique()->randomElement([
                'Elektronik',
                'Pakaian Pria',
                'Pakaian Wanita',
                'Makanan Ringan',
                'Minuman',
                'Alat Tulis',
                'Aksesoris'
            ]),
        ];
    }
}
