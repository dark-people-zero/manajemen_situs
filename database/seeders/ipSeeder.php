<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ipModel;

class ipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ipModel::insert([
            [
                'user_id' => 1,
                'username' => 'superAdmin',
                'ip' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'username' => 'admin',
                'ip' => '127.0.0.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
