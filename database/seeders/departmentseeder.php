<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class departmentseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Department::insert([
            ['name'=>'Office'],
            ['name'=>'Science'],
            ['name'=>'Humanities'],
            ['name'=>'Law'],
            ['name'=>'Education'],
            ['name'=>'Social Science'],
            ['name'=>'Commerce'],
            ['name'=>'Dentistry'],
            ['name'=>'Fine Arts'],
        ]);
    }
}
