<?php

use Faker\Generator as Faker;

$factory->define(App\Votes\Domain\Models\Vote::class, function (Faker $faker) {
	return [
		'type' => true,
		'user_id' => 1,
	];
});
