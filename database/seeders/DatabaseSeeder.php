<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder sesuai urutan: Kategori dulu, baru Buku
        $this->call([
            KategoriSeeder::class,
            BukuSeeder::class,
        ]);
    }
}