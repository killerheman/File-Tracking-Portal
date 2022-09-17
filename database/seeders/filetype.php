<?php

namespace Database\Seeders;

use App\Models\FileType as ModelsFileType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class filetype extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ModelsFileType::insert([[
            'name' => 'departmental'
        ],
        [
            'name' => 'official'
        ]]);

        return $data;
    }
}
