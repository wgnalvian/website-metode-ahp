<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesComparTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_compar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id_a')->references('id')->on('categories')->onDelete('cascade');
            $table->string('value');
            $table->foreignId('category_id_b')->references('id')->on('categories');
            $table->string('eigen_value')->nullable();
            $table->dropForeign('categories_compar_category_id_a_foreign');
           
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
        Schema::dropIfExists('categories_compar');
    }
}
