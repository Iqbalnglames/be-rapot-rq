<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KelasSeeder::class,
            // MapelSeeder::class,
            KategoriMapelSeeder::class,
            SemesterSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'slug' => 'admin',
        //     'username' => 'admin',
        //     'password' => Hash::make('admin'),
        //     'email' => 'iqbal050202@gmail.com',
        //     'isActive' => true,
        // ]);
    }
}
