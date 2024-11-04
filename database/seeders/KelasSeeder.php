<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 7; $i <= 12; $i++){
            DB::table('kelas')->insert([
                'kelas' => 'Kelas '.$i,
                'slug' => 'kelas-'.$i,
                'kkm' => 76
            ]);
        }
    }
}
