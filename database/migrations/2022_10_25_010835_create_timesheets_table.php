<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id('timesheet_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->unsignedBigInteger('fk_department_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->unsignedBigInteger('fk_project_id');
            $table->unsignedBigInteger('fk_approval_id')->nullable();

            $table->dateTime('timesheet_start_date');
            $table->dateTime('timesheet_end_date');
            $table->integer('timesheet_total_duration')->nullable()->default('0');
            $table->tinyInteger('timesheet_status')->default('0')->comment('0=draft or created, 1=posting');
            $table->dateTime('timesheet_approval_date')->nullable();
            $table->timestamps();

            $table->foreign('fk_company_id')->references('company_id')->on('companies');
            $table->foreign('fk_department_id')->references('department_id')->on('departments');
            $table->foreign('fk_employee_id')->references('employee_id')->on('employees');
            $table->foreign('fk_project_id')->references('project_id')->on('projects');
            $table->foreign('fk_approval_id')->references('employee_id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
};
