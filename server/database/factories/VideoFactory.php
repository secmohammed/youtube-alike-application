<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Videos\Domain\Models\Video::class, function (Faker $faker) {
	$created_at = Carbon::create(2016, 5, 28, 0, 0, 0);
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
		'created_at' => $created_at->addWeeks(rand(1, 52))->format('Y-m-d H:i:s'),
	];
});
