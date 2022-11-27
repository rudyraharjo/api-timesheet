<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ACC ROOT
        DB::table('users')->insert(
            [
                'fk_role_id'                => 1,
                'email'                => "root@ecocare.id",
                'password'             => app('hash')->make('Rahasia*1!'),
                'activation_token'     => sha1(time()),
                'email_verified_at'    => date("Y-m-d H:i:s"),
                'created_at'                => date("Y-m-d H:i:s"),
                'updated_at'                => date("Y-m-d H:i:s"),
            ]
        );
        // END ACC ROOT

        // ACC ESS
        DB::table('users')->insert(
            [
                'fk_role_id'           => 2,
                'email'                => "rraharjo.rudy@ecocare.id",
                'password'             => app('hash')->make('Rahasia*1!'),
                'activation_token'     => sha1(time()),
                'email_verified_at'    => date("Y-m-d H:i:s"),
                'created_at'           => date("Y-m-d H:i:s"),
                'updated_at'           => date("Y-m-d H:i:s")
            ]
        );

        $lastId = DB::getPdo()->lastInsertId();

        $branchHO = 1;
        DB::table('employees')->insert(
            [
                'fk_branch_id'              => $branchHO,
                'fk_user_id'                => $lastId,
                'fk_department_id'          => 7,
                'fk_job_title_id'           => 15,
                'fk_job_type_id'            => 3,
                'employee_nik'              => '01/PKWTTIII/22022',
                'employee_fullname'         => "Rudy Raharjo",
                'employee_gender'           => 'male',
                'employee_join_date'        => date("Y-m-d H:i:s"),
                'created_at'                => date("Y-m-d H:i:s"),
                'updated_at'                => date("Y-m-d H:i:s")
            ]
        );
        for ($i = 1; $i <= 30; $i++) {

            DB::table('users')->insert(
                [
                    'fk_role_id'                => 2,
                    'email'                => "employee" . $i . "@ecocare.id",
                    'password'             => app('hash')->make('password'),
                    'activation_token'     => sha1(time()),
                    'email_verified_at'    => date("Y-m-d H:i:s"),
                    'created_at'                => date("Y-m-d H:i:s"),
                    'updated_at'                => date("Y-m-d H:i:s")
                ]
            );

            $lastId = DB::getPdo()->lastInsertId();

            $branchHO = 1;
            DB::table('employees')->insert(
                [
                    'fk_branch_id'              => $branchHO,
                    'fk_user_id'                => $lastId,
                    'employee_nik'              => $i . "/PKWTTIII/" . $i,
                    'employee_fullname'         => "employee" . $i,
                    'employee_gender'           => 'male',
                    'employee_join_date'        => date("Y-m-d H:i:s"),
                    'created_at'                => date("Y-m-d H:i:s"),
                    'updated_at'                => date("Y-m-d H:i:s")
                ]
            );
        }

        for ($i = 31; $i <= 60; $i++) {

            DB::table('users')->insert(
                [
                    'fk_role_id'                => 2,
                    'email'                => "employee" . $i . "@ecocare.id",
                    'password'             => app('hash')->make('password'),
                    'activation_token'     => sha1(time()),
                    'email_verified_at'    => date("Y-m-d H:i:s"),
                    'created_at'                => date("Y-m-d H:i:s"),
                    'updated_at'                => date("Y-m-d H:i:s")
                ]
            );

            $lastId = DB::getPdo()->lastInsertId();
            $branchHO = 1;
            DB::table('employees')->insert(
                [
                    'fk_branch_id'              => $branchHO,
                    'fk_user_id'                => $lastId,
                    'employee_nik'              => $i . "/PKWTTIII/" . $i,
                    'employee_fullname'         => "employee" . $i,
                    'employee_gender'           => 'female',
                    'employee_join_date'        => date("Y-m-d H:i:s"),
                    'created_at'                => date("Y-m-d H:i:s"),
                    'updated_at'                => date("Y-m-d H:i:s")
                ]
            );
        }
        // END ACC ESS
    }
}
