<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $this->faker->sentence(),
        'content' => $this->faker->sentence(10),
        'user_id' => 1,
        'category_id' => 1,
        'seo_title' => $this->faker->sentence(4),
        'seo_description' => $this->faker->sentence(6),
        'slug'=> 'post-'.rand(1,100),
        'type' => 'post',
        'status' => rand(0, 1),
        'thumbnail' => 'https://via.placeholder.com/500.png',
        'created_at' => $this->faker->dateTime($max = 'now', $timezone = null)
    ];
});
