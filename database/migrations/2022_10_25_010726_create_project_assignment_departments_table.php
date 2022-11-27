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
        Schema::create('project_assignment_departments', function (Blueprint $table) {
            $table->id('project_assignment_department_id');
            $table->unsignedBigInteger('fk_project_id');
            $table->unsignedBigInteger('fk_department_id');
            $table->timestamps();

            $table->foreign('fk_department_id')->references('department_id')->on('departments');
            $table->foreign('fk_project_id')->references('project_id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_assignment_departments');
    }
};
