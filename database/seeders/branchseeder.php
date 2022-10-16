<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class branchseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Branch::insert([
            ['name'=>'Botany','department_id'=>2],
            ['name'=>'Physics','department_id'=>2],
            ['name'=>'Chemistery','department_id'=>2],
            ['name'=>'Mathmatics','department_id'=>2],
            ['name'=>'Zoology','department_id'=>2],
            ['name'=>'Humanities','department_id'=>3],
            ['name'=>'English','department_id'=>3],
            ['name'=>'Maithili','department_id'=>3],
            ['name'=>'Sanskrit','department_id'=>3],
            ['name'=>'Philosophy','department_id'=>3],
            ['name'=>'Urdu','department_id'=>3],
            ['name'=>'Law','department_id'=>4],
             ['name'=>'Education','department_id'=>5],
             ['name'=>'Social Science','department_id'=>6],
             ['name'=>'Ancient History And Culture','department_id'=>6],
             ['name'=>'Economics','department_id'=>6],
             ['name'=>'Geography','department_id'=>6],
             ['name'=>'History','department_id'=>6],
             ['name'=>'Psychology','department_id'=>6],
             ['name'=>'Political Science','department_id'=>6],
             ['name'=>'Sociology','department_id'=>6],
             ['name'=>'Commerce','department_id'=>7],
             ['name'=>'Dentistry','department_id'=>8],
             ['name'=>'Fine Arts','department_id'=>9],
             ['name'=>'Music And Dramatics','department_id'=>9],
             

        ]);
      
    }
}
