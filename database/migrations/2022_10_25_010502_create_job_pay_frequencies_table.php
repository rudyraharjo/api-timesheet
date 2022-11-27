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
        Schema::create('job_pay_frequencies', function (Blueprint $table) {
            $table->id('job_pay_frequency_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->string('job_pay_frequency_name', 100)->unique();
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
        Schema::dropIfExists('job_pay_frequencies');
    }
};
