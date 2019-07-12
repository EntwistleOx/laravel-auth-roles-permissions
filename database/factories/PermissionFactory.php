<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Caffeinated\Shinobi\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug,
        'description' => $faker->sentence
    ];
});
