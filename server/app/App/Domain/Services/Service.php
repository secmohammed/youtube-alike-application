<?php

namespace App\App\Domain\Services;

abstract class Service {
	abstract public function handle();
	public function user() {
		if (auth()->check()) {
			return auth()->user();
		}
		if (request()->headers->has('Authorization') && ($user = \JWTAuth::toUser(substr(request()->header('Authorization'), 7)))) {
			return $user;
		}
	}
}