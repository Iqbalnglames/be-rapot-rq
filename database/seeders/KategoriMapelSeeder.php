<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_mapels')->insert(
        
        [
            'kategori_mapel' => 'Pendidikan Umum',
            'slug' => 'pendidikan-umum'
        ]);
    }
}
