<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Caffeinated\Shinobi\Models\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->slug(2),
        'description' => $faker->sentence,
        'special' => null
    ];
});
