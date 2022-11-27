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
        Schema::create('employee_emergency_contacts', function (Blueprint $table) {
            $table->id('employee_emergency_contact_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->string('employee_emergency_contact_name', 50);
            $table->string('employee_emergency_contact_relationship', 20)->nullable();
            $table->string('employee_emergency_contact_home_phone', 20)->nullable();
            $table->string('employee_emergency_contact_mobile_phone', 20)->nullable();
            $table->string('employee_emergency_contact_work_phone', 20)->nullable();
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
        Schema::dropIfExists('employee_emergency_contacts');
    }
};
