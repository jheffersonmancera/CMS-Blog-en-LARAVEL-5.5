<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {//*1CategoryFactory.php
    $title= $faker->sentence(4);//*3CategoryFactory.php
    return [
        'name'=> $title,
        'slug'=> str_slug($title),//*2CategoryFactory.php
        'body'=> $faker->text(500),
    ];
});
