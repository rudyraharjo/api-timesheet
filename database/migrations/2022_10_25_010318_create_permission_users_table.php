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
        Schema::create('permission_users', function (Blueprint $table) {
            $table->unsignedBigInteger('module_app_id');
            $table->unsignedBigInteger('permission_id');
            $table->integer('value')->nullable();
            $table->string('param')->nullable();
            $table->timestamps();

            $table->foreign('module_app_id')->references('module_app_id')->on('module_apps');
            $table->foreign('permission_id')->references('permission_id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_users');
    }
};
