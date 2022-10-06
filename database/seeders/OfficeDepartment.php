<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OfficeDepartment as OfficeDepartmentModal;
class OfficeDepartment extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return OfficeDepartmentModal::insert([
            ['name'=>'Department Of Botany','sort_name'=>'DepBot'],
            ['name'=>'Department Of Zoology','sort_name'=>'DepZool'],
            ['name'=>'Department Of Phycology','sort_name'=>'DepPhy'],
            ['name'=>'Department Of Humanity','sort_name'=>'DepHum'],
            ['name'=>'VC Office','sort_name'=>'OffVc'],
            ['name'=>'Registrar Office','sort_name'=>'OffReg'],
            
         
        ]);
    }
}
