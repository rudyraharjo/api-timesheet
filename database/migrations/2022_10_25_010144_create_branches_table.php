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
        Schema::create('branches', function (Blueprint $table) {
            $table->id('branch_id');
            $table->bigInteger('parent_id')->default(0);
            $table->unsignedBigInteger('fk_company_id');
            $table->string('branch_code', 15);
            $table->string('branch_name', 100);
            $table->string('branch_level')->default('branch'); // HO, REGION, BRANCH
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
        Schema::dropIfExists('branches');
    }
};
