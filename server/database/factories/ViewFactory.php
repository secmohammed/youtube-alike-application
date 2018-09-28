<?php

use Faker\Generator as Faker;

$factory->define(App\Videos\Domain\Models\View::class, function (Faker $faker) {
	return [
		'ip' => '127.0.0.1',
	];
});
