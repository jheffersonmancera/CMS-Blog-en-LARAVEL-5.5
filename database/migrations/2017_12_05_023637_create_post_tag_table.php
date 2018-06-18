<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {//*1_create_post_tag_table.php: 
            $table->increments('id');

            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();

            $table->timestamps();

            //Relation
            $table->foreign('post_id')->references('id')->on('posts')//*2_create_post_tag_table.php:
                ->onDelete('cascade')//*3_create_post_tag_table.php:
                ->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')//*4_create_post_tag_table.php:
                ->onDelete('cascade')//*5_create_post_tag_table.php:
                ->onUpdate('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
