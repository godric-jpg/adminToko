<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Laptop Gaming ROG',
                'slug' => Str::slug('Laptop Gaming ROG'),
                'description' => 'Laptop gaming high performance dengan RTX 4060',
                'category_id' => 1, // Elektronik
                'price' => 25000000,
                'img' => null,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartphone Android 5G',
                'slug' => Str::slug('Smartphone Android 5G'),
                'description' => 'Smartphone layar AMOLED 120Hz',
                'category_id' => 1, // Elektronik
                'price' => 4500000,
                'img' => null,
                'stock' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kemeja Flannel Pria',
                'slug' => Str::slug('Kemeja Flannel Pria'),
                'description' => 'Kemeja flannel bahan katun nyaman',
                'category_id' => 2, // Fashion
                'price' => 189000,
                'img' => null,
                'stock' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sepatu Lari Ringan',
                'slug' => Str::slug('Sepatu Lari Ringan'),
                'description' => 'Sepatu lari untuk harian dan jogging',
                'category_id' => 4, // Olahraga
                'price' => 650000,
                'img' => null,
                'stock' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kopi Arabika 250g',
                'slug' => Str::slug('Kopi Arabika 250g'),
                'description' => 'Kopi arabika single origin',
                'category_id' => 3, // Makanan & Minuman
                'price' => 85000,
                'img' => null,
                'stock' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
