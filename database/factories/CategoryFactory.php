<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {//se define el modelo en App\Category
    $title= $faker->sentence(4);
    return [
        'name'=> $title,
        'slug'=> str_slug($title),
        'body'=> $faker->text(500),
    ];
});
