<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Permission::insert([[
            'name' => 'show_all_files',
            'guard_name' => 'fileuser'
        ]
        ]);

        return $data;
    }
}
