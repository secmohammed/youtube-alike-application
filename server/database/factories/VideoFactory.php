<?php

use Faker\Generator as Faker;

$factory->define(App\Videos\Domain\Models\Video::class, function (Faker $faker) {
	return [
		'channel_id' => 1,
		'uid' => uniqid('testing_', true),
		'title' => $faker->unique()->word,
		'description' => $faker->sentence,
		'visibility' => 'public',
		'processed' => false,
		'allow_votes' => true,
		'allow_comments' => true,
		'thumbnail' => 'default.png',
	];
});
