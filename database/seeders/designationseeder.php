<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class designationseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Designation::insert([
            ['name'=>'Head'],
            ['name'=>'Teacher'],
            ['name'=>'Officer'],
            ['name'=>'Non-Teacher'],
            ['name'=>'Peon'],
        ]);
    }
}
