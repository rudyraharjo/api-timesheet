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
        Schema::create('timesheet_activities', function (Blueprint $table) {
            $table->id('timesheet_activity_id');
            $table->unsignedBigInteger('fk_timesheet_id');
            $table->unsignedBigInteger('fk_employee_id');

            $table->date('timesheet_activity_work_date');
            $table->integer('timesheet_activity_duration')->nullable()->default('0');
            $table->text('timesheet_activity_notes')->nullable();
            $table->timestamps();

            $table->foreign('fk_timesheet_id')->references('timesheet_id')->on('timesheets');
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
        Schema::dropIfExists('timesheet_activities');
    }
};
