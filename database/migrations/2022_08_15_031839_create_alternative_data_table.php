<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativeDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->references('id')->on('sub_categories');
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_data');
    }
}
