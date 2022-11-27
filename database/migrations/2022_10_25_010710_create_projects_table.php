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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->unsignedBigInteger('fk_createdby_id');
            
            $table->string('project_title');
            $table->text('project_description')->nullable();
            $table->tinyInteger('project_status')->default('0')->comment('0=draft, 1=on_going, 2=finish');
            $table->dateTime('project_start_date')->nullable();
            $table->dateTime('project_end_date')->nullable();
            $table->timestamps();

            $table->foreign('fk_company_id')->references('company_id')->on('companies');
            $table->foreign('fk_createdby_id')->references('employee_id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
