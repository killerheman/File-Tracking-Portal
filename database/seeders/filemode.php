<?php

namespace Database\Seeders;

use App\Models\FileMode as ModelsFileMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class filemode extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ModelsFileMode::insert([[
            'name' => 'transfering'
        ],
        [
            'name' => 'recieved'
        ],
        [
            'name' => 'generated'
        ],
        [
            'name' => 'denied'
        ]]);

        return $data;
    }
}
