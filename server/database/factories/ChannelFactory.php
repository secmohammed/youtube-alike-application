<?php

use Faker\Generator as Faker;

$factory->define(App\Channels\Domain\Models\Channel::class, function (Faker $faker) {
	return [
		'user_id' => 1,
		'name' => $name = $faker->unique()->word,
		'slug' => str_slug($name),
		'description' => $faker->sentence,
	];
});
