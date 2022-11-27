<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_id = 2;
        $level = 'branch';

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'HO',
            'branch_name'   => 'Head Office',
            'branch_level'  => 'HO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // HO // 1

        // Branch
        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BA',
            'branch_name'   => 'Bali',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BDG',
            'branch_name'   => 'Bandung',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BTM',
            'branch_name'   => 'Batam',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BCC',
            'branch_name'   => 'Bekasi Cikarang Cibubur',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BGR',
            'branch_name'   => 'Bogor',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BST',
            'branch_name'   => 'Bintaro Serpong Tangerang',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'CBN',
            'branch_name'   => 'Cirebon',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'JKT1',
            'branch_name'   => 'Jakarta 1 (Manggarai)',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'JKT2',
            'branch_name'   => 'Jakarta 2 (Pasar Minggu)',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'JKT3',
            'branch_name'   => 'Jakarta 3 (Joglo)',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'JMR',
            'branch_name'   => 'Jember',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'YYK',
            'branch_name'   => 'Yogyakarta',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'LMBK',
            'branch_name'   => 'Lombok',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'MKS',
            'branch_name'   => 'Makasar',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'MND',
            'branch_name'   => 'Manado',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => '',
            'branch_name'   => 'MDN',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'PLG',
            'branch_name'   => 'Palembang',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'PTK',
            'branch_name'   => 'Pontianak',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'PWT',
            'branch_name'   => 'Purwokerto',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'SMR - BPP',
            'branch_name'   => 'Samarinda / Balikpapan',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'SMG',
            'branch_name'   => 'Semarang',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'BGR (STL)',
            'branch_name'   => 'Sentul',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'SKT (SLO)',
            'branch_name'   => 'Solo',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('branches')->insert([
            'parent_id'     => 0,
            'fk_company_id' => $company_id,
            'branch_code'   => 'SBY',
            'branch_name'   => 'Surabaya',
            'branch_level'  => $level,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        // End Branch
    }
}
