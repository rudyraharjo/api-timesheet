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
        Schema::create('module_apps', function (Blueprint $table) {
            $table->id('module_app_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->string('module_app_slug', 100)->unique();
            $table->string('module_app_name', 100)->unique();
            $table->text('module_app_icon')->nullable();
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
        Schema::dropIfExists('module_apps');
    }
};
