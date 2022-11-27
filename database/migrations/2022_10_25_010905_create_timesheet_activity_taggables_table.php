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
        Schema::create('timesheet_activity_taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_timesheet_activity_id');
            $table->unsignedBigInteger('fk_timesheet_tag_id');

            $table->timestamps();

            $table->foreign('fk_timesheet_tag_id')->references('tag_id')->on('tags');
            $table->foreign('fk_timesheet_activity_id')->references('timesheet_activity_id')->on('timesheet_activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheet_activity_taggables');
    }
};
