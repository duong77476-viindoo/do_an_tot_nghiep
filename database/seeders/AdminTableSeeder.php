<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role1 = Role::where('name','Quản lý')->first();
        $role2 = Role::where('name','Bán hàng')->first();
        $role3 = Role::where('name','Nhân viên')->first();

        $quan_ly = Admin::create([
            'name'=>'Dương pro',
            'email'=>'duongpro@gmail.com',
            'password'=>md5('123456'),
            'phone'=>'4234232',
        ]);
        $ban_hang = Admin::create([
            'name'=>'Dương pro 1',
            'email'=>'duongpro1@gmail.com',
            'password'=>md5('123456'),
            'phone'=>'4234232',
        ]);
        $nhan_vien = Admin::create([
            'name'=>'Dương pro 2',
            'email'=>'duongpro2@gmail.com',
            'password'=>md5('123456'),
            'phone'=>'4234232',
        ]);

        $quan_ly->roles()->attach($role1);
        $ban_hang->roles()->attach($role2);
        $nhan_vien->roles()->attach($role3);
    }
}
