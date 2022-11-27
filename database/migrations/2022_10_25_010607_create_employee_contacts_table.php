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
        Schema::create('employee_contacts', function (Blueprint $table) {
            $table->id('employee_contact_id');
            $table->unsignedBigInteger('fk_employee_id');
            $table->string('employee_contact_home_phone', 20)->nullable();
            $table->string('employee_contact_mobile_phone', 20);
            $table->string('employee_contact_work_email', 50)->nullable();
            $table->string('employee_contact_other_email', 50)->nullable();
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
        Schema::dropIfExists('employee_contacts');
    }
};
