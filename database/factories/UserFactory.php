<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Provider::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone' => $faker->unique()->phoneNumber,
        'address' => $faker->address
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'provider_id' => factory(\App\Provider::class),
        'stock' => $faker->numberBetween(10, 100),
        'price' => $faker->randomElement([200, 300, 400, 500]),
        'description' => $faker->paragraph(1)
    ];
});

$factory->define(App\BranchOffice::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => str_slug($name, '-'),
    ];
});