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
        Schema::create('job_types', function (Blueprint $table) {
            $table->id('job_type_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->string('job_type_code', 15)->unique();
            $table->string('job_type_name', 150);
            $table->text('job_type_description')->nullable();
            $table->timestamps();

            $table->foreign('fk_company_id')->references('company_id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_types');
    }
};
