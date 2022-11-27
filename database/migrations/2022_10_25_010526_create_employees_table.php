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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->unsignedBigInteger('fk_user_id');

            $table->unsignedBigInteger('fk_branch_id')->nullable();
            $table->unsignedBigInteger('fk_department_id')->nullable();
            $table->unsignedBigInteger('fk_job_title_id')->nullable();
            $table->unsignedBigInteger('fk_job_type_id')->nullable();

            $table->string('employee_nik', 32)->unique();
            $table->string('employee_fullname', 200);
            $table->string('employee_avatar')->nullable();
            $table->string('employee_birth_place')->nullable();
            $table->date('employee_birth_date')->nullable();
            $table->string('employee_marital_status', 15)->nullable()->comment('single, married');
            $table->enum('employee_gender', ['male', 'female'])->comment('male, female')->nullable();
            $table->date('employee_join_date')->nullable();
            $table->tinyInteger('employee_status')->default('1')->comment('1 = is_active, 0 = no active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fk_branch_id')->references('branch_id')->on('branches');
            $table->foreign('fk_user_id')->references('user_id')->on('users');
            $table->foreign('fk_department_id')->references('department_id')->on('departments');
            $table->foreign('fk_job_title_id')->references('job_title_id')->on('job_titles');
            $table->foreign('fk_job_type_id')->references('job_type_id')->on('job_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
