<?php

namespace Database\Seeders;

use App\Models\FileStatus as ModelsFileStatus;
use Carbon\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class filestatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ModelsFileStatus::insert([[
            'name' => 'verification'
        ],
        [
            'name' => 'confirmation'
        ],
        [
            'name' => 'query'
        ],
        [
            'name' => 'other'
        ]]);

        return $data;
    }
}
