<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'email'                => "root@ecocare.id",
                'password'             => app('hash')->make('Rahasia*1!'),
                'activation_token'     => sha1(time()),
                'email_verified_at'    => date("Y-m-d H:i:s"),
                'created_at'           => date("Y-m-d H:i:s"),
                'updated_at'           => date("Y-m-d H:i:s"),
            ]
        );
    }
}
