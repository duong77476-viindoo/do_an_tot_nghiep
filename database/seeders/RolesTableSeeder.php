<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Role::truncate();//xóa csdl bảng role
        Role::create([
            'name'=>'Quản lý'
        ]);
        Role::create([
            'name'=>'Bán hàng'
        ]);
        Role::create([
            'name'=>'Nhân viên'
        ]);
    }
}
