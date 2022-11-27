<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobGradePayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For Job Pay Grade
        DB::table('job_pay_grades')->insert([
            'fk_company_id' => 2,
            'job_pay_grade_code' => 'G1',
            'job_pay_grade_name' => 'GRADE 1',
            'job_pay_grade_min_salary' => 30000000,
            'job_pay_grade_max_salary' => 50000000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_grades')->insert([
            'fk_company_id' => 2,
            'job_pay_grade_code' => 'G2',
            'job_pay_grade_name' => 'GRADE 2',
            'job_pay_grade_min_salary' => 10000000,
            'job_pay_grade_max_salary' => 30000000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_grades')->insert([
            'fk_company_id' => 2,
            'job_pay_grade_code' => 'G3',
            'job_pay_grade_name' => 'GRADE 3',
            'job_pay_grade_min_salary' => 10000000,
            'job_pay_grade_max_salary' => 15000000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_grades')->insert([
            'fk_company_id' => 2,
            'job_pay_grade_code' => 'G4',
            'job_pay_grade_name' => 'GRADE 4',
            'job_pay_grade_min_salary' => 0,
            'job_pay_grade_max_salary' => 15000000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_grades')->insert([
            'fk_company_id' => 2,
            'job_pay_grade_code' => 'G5',
            'job_pay_grade_name' => 'GRADE 5',
            'job_pay_grade_min_salary' => 0,
            'job_pay_grade_max_salary' => 5000000,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End Job Pay Grade

        // For Job Pay Frequencies
        DB::table('job_pay_frequencies')->insert([
            'fk_company_id' => 2,
            'job_pay_frequency_name' => 'Monthly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_frequencies')->insert([
            'fk_company_id' => 2,
            'job_pay_frequency_name' => 'Weekly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_frequencies')->insert([
            'fk_company_id' => 2,
            'job_pay_frequency_name' => 'Hourly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_pay_frequencies')->insert([
            'fk_company_id' => 2,
            'job_pay_frequency_name' => 'Semi Monthly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End Job Pay Frequencies

        // For Job Types
        DB::table('job_types')->insert([
            'fk_company_id' => 2,
            'job_type_code' => 'FREE',
            'job_type_name' => 'Freelance',
            'job_type_description' => 'Semi Monthly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_types')->insert([
            'fk_company_id' => 2,
            'job_type_code' => 'PKWT',
            'job_type_name' => 'Full time Contact',
            'job_type_description' => 'Semi Monthly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('job_types')->insert([
            'fk_company_id' => 2,
            'job_type_code' => 'PKWTT',
            'job_type_name' => 'Full time Permanent',
            'job_type_description' => 'Semi Monthly',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // End Job Types
    }
}
