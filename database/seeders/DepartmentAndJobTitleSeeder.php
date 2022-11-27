<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentAndJobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'MA',
            'department_name' => 'Management & Administration',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'ACCT',
            'department_name' => 'Accounting',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'FINANC',
            'department_name' => 'Finance',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'GA',
            'department_name' => 'General Affair',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'SHE',
            'department_name' => 'Safety, Health and Environment',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'HR',
            'department_name' => 'Human Resource',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'IT',
            'department_name' => 'Information Technology',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'IA',
            'department_name' => 'Internal Audit',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'MTO',
            'department_name' => 'Management Trainee Officer',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'MARCOM',
            'department_name' => 'Marketing Communication',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'PURC',
            'department_name' => 'Purcashing',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('departments')->insert([
            'fk_company_id' => 2,
            'department_code' => 'SLS',
            'department_name' => 'Sales',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        // For MA
        DB::table('job_titles')->insert([
            'fk_department_id' => 1,
            'job_title_name' => 'Managing Director (MD)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 1,
            'job_title_name' => 'Board of Director (BOD)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 1,
            'job_title_name' => 'General Manager (GM)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 1,
            'job_title_name' => 'MD Secretary',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 1,
            'job_title_name' => 'BOD Secretary',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End MA

        // For ACCT
        DB::table('job_titles')->insert([
            'fk_department_id' => 2,
            'job_title_name' => 'Head of Accounting',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 2,
            'job_title_name' => 'Cost Accounting',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 2,
            'job_title_name' => 'Account Payable (AP)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 2,
            'job_title_name' => 'Account Receivable (AR)',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End ACCT

        // For FINANC
        DB::table('job_titles')->insert([
            'fk_department_id' => 3,
            'job_title_name' => 'Head of Finance',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 3,
            'job_title_name' => 'Chasier',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End FINANC

        // For IT
        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'Head of Information Technology',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'System Engineer',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'Technical Support',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'Programmer',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'Full Stack Developer',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('job_titles')->insert([
            'fk_department_id' => 7,
            'job_title_name' => 'Mobile Developer',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End IT
    }
}
