<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {//*1_create_categories_table.php
            $table->increments('id');
            $table->string('name', 128);
            $table->string('slug', 128)->unique();//*2_create_categories_table.php
            $table->mediumText('body')->nullable();//nullable: puede estar vacio o nulo.


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
        Schema::dropIfExists('categories');
    }
}
