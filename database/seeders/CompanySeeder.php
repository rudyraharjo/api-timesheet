<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'company_code' => 'DEV',
            'company_name' => 'GROUP INTERNAL ECO DEV',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 1

        DB::table('companies')->insert([
            'company_code' => 'ECOCARE',
            'company_name' => 'PT. Indocare Pasific',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 2

        DB::table('companies')->insert([
            'company_code' => 'TBI',
            'company_name' => 'PT. Tukang Bersih Indonesia',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 3

        DB::table('companies')->insert([
            'company_code' => 'PESTCARE',
            'company_name' => 'PT. Indocitra Pasific',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 4
    }
}
