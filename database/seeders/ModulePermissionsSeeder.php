<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_id = 2;

        // MODULE PERMISSON
        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'create',
            'permission_name' => 'create',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 1

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'read',
            'permission_name' => 'read',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 2

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'update',
            'permission_name' => 'update',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 3

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'delete',
            'permission_name' => 'delete',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 4

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'approve',
            'permission_name' => 'approve',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 5

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'reject',
            'permission_name' => 'reject',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 6

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'import',
            'permission_name' => 'import',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 7

        DB::table('permissions')->insert([
            'fk_company_id' => $company_id,
            'permission_slug' => 'export',
            'permission_name' => 'export',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 8

        // MODULE APP
        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'dashboard',
            'module_app_name' => 'Dashboard',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 1

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'company',
            'module_app_name' => 'Company',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 2

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'branch',
            'module_app_name' => 'Branch',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 3

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'role',
            'module_app_name' => 'Role',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 4

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'permission',
            'module_app_name' => 'Permission',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 5

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'application',
            'module_app_name' => 'Application',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 6

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'user',
            'module_app_name' => 'User',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 7

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'permission-user',
            'module_app_name' => 'Permission User',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 8

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'department',
            'module_app_name' => 'Department',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 9

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'job-title',
            'module_app_name' => 'Job Title',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 10

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'job-pay-grade',
            'module_app_name' => 'Job Pay Grade',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 11

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'job-pay-frequency',
            'module_app_name' => 'Job Pay Frequency',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 12

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'job-type',
            'module_app_name' => 'Job Type',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 13

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'employee',
            'module_app_name' => 'employee',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 14

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'project',
            'module_app_name' => 'project',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 15

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'tag',
            'module_app_name' => 'tag',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 16

        DB::table('module_apps')->insert([
            'fk_company_id' => $company_id,
            'module_app_slug' => 'timesheet',
            'module_app_name' => 'Timesheet',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]); // 17

        DB::table('permission_users')->insert([
            'module_app_id' => 1,
            'permission_id' => 2,
            'value'         => 15,
            'param'         => 'job_title_id',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]); // read dashboard

        DB::table('permission_users')->insert([
            'module_app_id' => 2,
            'permission_id' => 1,
            'value'         => 15,
            'param'         => 'job_title_id',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]); // create

        DB::table('permission_users')->insert([
            'module_app_id' => 2,
            'permission_id' => 2,
            'value'         => 15,
            'param'         => 'job_title_id',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]); // read

        DB::table('permission_users')->insert([
            'module_app_id' => 2,
            'permission_id' => 3,
            'value'         => 15,
            'param'         => 'job_title_id',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]); // update

        DB::table('permission_users')->insert([
            'module_app_id' => 2,
            'permission_id' => 4,
            'value'         => 15,
            'param'         => 'job_title_id',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),
        ]); // delete

    }
}
