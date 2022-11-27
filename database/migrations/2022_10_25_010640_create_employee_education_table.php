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
        Schema::create('employee_education', function (Blueprint $table) {
            $table->id('employee_education_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->enum('employee_education_level', ['Junior High School', 'Senior High School', 'Vocational School', 'University / College Student'])->comment('Junior High School, Senior High School, Vocational School, University / College Student');
            $table->string('employee_education_institute_name');
            $table->string('employee_education_major', 30); // Major/Specialization
            $table->string('employee_education_gpa', 10); // GPA/Score/IPK
            $table->date('employee_education_period_start')->nullable();
            $table->date('employee_education_period_end')->nullable();
            $table->timestamps();

            $table->foreign('fk_employee_id')->references('employee_id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_education');
    }
};
