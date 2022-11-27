<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'ROOT',
            'role_display_name' => 'ROOT Apps (Super User)',
            'role_description' => 'ROOT Apps (Super User)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 1

        DB::table('roles')->insert([
            'role_name' => 'ESS',
            'role_display_name' => 'Employee Self Service',
            'role_description' => 'Employee Self Service',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 2
    }
}
