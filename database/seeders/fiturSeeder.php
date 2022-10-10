<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\fitur;

class fiturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        fitur::insert([
            [
                'name' => 'Popup APK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Header APK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hader Corousel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Button Action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Icon Sosmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promosi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Before Footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Footer Protection',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Link Alternatif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
