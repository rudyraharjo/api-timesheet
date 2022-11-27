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
        Schema::create('timesheet_action_logs', function (Blueprint $table) {
            $table->id('timesheet_action_log_id');
            $table->unsignedBigInteger('fk_timesheet_id');
            $table->unsignedBigInteger('fk_performedby_id');
            $table->string('timesheet_action_log_action')->nullable();
            $table->string('timesheet_action_log_notes')->nullable();
            $table->timestamps();

            $table->foreign('fk_timesheet_id')->references('timesheet_id')->on('timesheets');
            $table->foreign('fk_performedby_id')->references('employee_id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheet_action_logs');
    }
};
