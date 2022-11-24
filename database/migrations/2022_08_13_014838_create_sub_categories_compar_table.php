<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesComparTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories_compar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('subcategory_id_a')->references('id')->on('sub_categories');
            $table->string('value');
            $table->foreignId('subcategory_id_b')->references('id')->on('sub_categories');
            $table->string('eigen_value')->nullable();
          
           
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
        Schema::dropIfExists('sub_categories_compar');
    }
}
