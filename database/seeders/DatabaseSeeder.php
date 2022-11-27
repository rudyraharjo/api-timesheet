<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ModulePermissionsSeeder::class);
        $this->call(DepartmentAndJobTitleSeeder::class);
        $this->call(JobGradePayTypeSeeder::class);
        $this->call(UserEmployeeSeeder::class);
    }
}
