<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\typeElement;

class typeElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        typeElement::insert([
            [
                'name' => "input",
                'keterangan' => 'tag html input type text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "textarea",
                'keterangan' => 'tag html textarea',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "select",
                'keterangan' => 'tag html select option',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "images",
                'keterangan' => 'tag html img',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "checkbox",
                'keterangan' => 'tag html checkbox',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "switch",
                'keterangan' => 'tag html checkbox di modif jadi switch',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "color",
                'keterangan' => 'tag html input tetapi dengan pluigin color',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
