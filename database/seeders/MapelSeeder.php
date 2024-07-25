<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = ['MTK', 'IPA', 'IPS'];
        for($i = 0; $i < $mapel; $i++)
        {
            DB::table('mapels')->insert([
                'nama_mapel' => $mapel[$i],
                'slug' => Str::slug($mapel[$i]),
            ]);
        }
    }
}
