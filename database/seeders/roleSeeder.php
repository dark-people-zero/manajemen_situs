<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        role::insert([
            [
                'name' => 'Visitor',
                'role_code' => 'visitor',
                'role_id' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guest',
                'role_code' => 'guest',
                'role_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'role_code' => 'user',
                'role_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasir',
                'role_code' => 'kasir',
                'role_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Super Admin',
                'role_code' => 'system',
                'role_id' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Leader',
                'role_code' => 'leader',
                'role_id' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'role_code' => 'admin',
                'role_id' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operator',
                'role_code' => 'operator',
                'role_id' => '7',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Snr. Manager',
                'role_code' => 'snrmanager',
                'role_id' => '8',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor',
                'role_code' => 'supervisor',
                'role_id' => '9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager',
                'role_code' => 'manager',
                'role_id' => '10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
