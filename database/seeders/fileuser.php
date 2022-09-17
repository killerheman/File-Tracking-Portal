<?php

namespace Database\Seeders;

use App\Models\FileUser as ModelsFileUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class fileuser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ModelsFileUser::insert([[
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'phone' => '889263723',
            'password' => '$2a$12$RMGjbbI9rk8QVWGsOuki1ONcL1PDIKAvZQwgr8CQT80ZRF3pnUAx6'
        ],
        [
            'first_name' => 'Superadmin',
            'last_name' => 'User',
            'email' => 'superadmin@gmail.com',
            'phone' => '8892637456',
            'password' => '$2a$12$RMGjbbI9rk8QVWGsOuki1ONcL1PDIKAvZQwgr8CQT80ZRF3pnUAx6'
        ]]);

        return $data;
    }
}
