<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = ['Pendidikan Umum', 'Pendidikan Agama'];
        for ($i = 0; $i < count($kategori); $i++) {
            DB::table('kategori_mapels')->insert([
                'kategori_mapel' => $kategori[$i],
                'slug' => Str::slug($kategori[$i]),
            ]);
        }
    }
}
