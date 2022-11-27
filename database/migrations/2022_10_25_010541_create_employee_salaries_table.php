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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id('employee_salary_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->unsignedBigInteger('fk_job_pay_grade_id')->nullable();
            $table->unsignedBigInteger('fk_job_pay_frequency_id')->nullable();
            $table->string('employee_salary_name', 100)->unique();
            $table->double('employee_salary_amount')->default(0);
            $table->text('employee_salary_description')->nullable();
            $table->timestamps();

            $table->foreign('fk_employee_id')->references('employee_id')->on('employees');
            $table->foreign('fk_job_pay_grade_id')->references('job_pay_grade_id')->on('job_pay_grades');
            $table->foreign('fk_job_pay_frequency_id')->references('job_pay_frequency_id')->on('job_pay_frequencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_salaries');
    }
};
