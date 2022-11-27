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
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->id('employee_address_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->string('employee_address_province');
            $table->string('employee_address_city');
            $table->string('employee_address_district');
            $table->string('employee_address_village')->nullable();
            $table->text('employee_address_street');
            $table->string('employee_address_postal_code', 20);
            $table->string('employee_address_latitude', 50);
            $table->string('employee_address_longtitude', 50);
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
        Schema::dropIfExists('employee_addresses');
    }
};
