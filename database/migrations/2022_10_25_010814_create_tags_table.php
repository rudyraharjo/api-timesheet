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
        Schema::create('tags', function (Blueprint $table) {
            $table->id('tag_id');
            $table->unsignedBigInteger('fk_company_id');
            $table->unsignedBigInteger('fk_project_id');
            $table->string('tag_slug', 30)->unique();
            $table->string('tag_name', 100)->nullable();
            $table->timestamps();

            $table->foreign('fk_company_id')->references('company_id')->on('companies');
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
        Schema::dropIfExists('tags');
    }
};
