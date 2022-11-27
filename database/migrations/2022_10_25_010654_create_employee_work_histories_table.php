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
        Schema::create('employee_work_histories', function (Blueprint $table) {
            $table->id('employee_work_history_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->string('employee_work_history_company_name', 100);
            $table->string('employee_work_history_job_title', 50);
            $table->date('employee_work_history_from_period')->nullable();
            $table->date('employee_work_history_to_period')->nullable();
            $table->text('employee_work_history_description')->nullable();
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
        Schema::dropIfExists('employee_work_histories');
    }
};
