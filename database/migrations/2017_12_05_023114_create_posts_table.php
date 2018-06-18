<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();//*1_create_posts_table.php:
            $table->integer('category_id')->unsigned();
            $table->string('name', 128);//*3_create_posts_table.php: 
            $table->string('slug', 128)->unique();//*4_create_posts_table.php:

            $table->mediumText('excerpt')->nullable();//*2_create_posts_table.php:   
            $table->text('body');//*5_create_posts_table.php:
            $table->enum('status',['PUBLISHED','DRAFT'])->default('DRAFT');//*6_create_posts_table.php:

            $table->string('file', 128)->nullable();
            $table->timestamps();

            //Relation
            $table->foreign('user_id')->references('id')->on('users')//*7_create_posts_table.php
                ->onDelete('cascade')//*8_create_posts_table.php
                ->onUpdate('cascade');//*9_create_posts_table.php
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')//*9_create_posts_table.php
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
        Schema::dropIfExists('posts');
    }
}
