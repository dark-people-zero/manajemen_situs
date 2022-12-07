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
                'fitur_code' => 'popup-model',
                'name' => 'Popup APK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'header-apk',
                'name' => 'Header APK',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'header-carousel',
                'name' => 'Hader Corousel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'button-action',
                'name' => 'Button Action',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'icon-sosmed',
                'name' => 'Icon Sosmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'promosi',
                'name' => 'Promosi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'before-footer',
                'name' => 'Before Footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'footer-protection',
                'name' => 'Footer Protection',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'link-alternatif',
                'name' => 'Link Alternatif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'barcode-qris',
                'name' => 'Barcode QRIS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fitur_code' => 'sort-list-bank',
                'name' => 'Sort List Bank',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
