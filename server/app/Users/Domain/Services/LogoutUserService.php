<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class LogoutUserService implements ServiceInterface {
	protected $users;
	public function __construct() {
	}
	public function handle($data = []) {
		auth()->logout();

		return new GenericPayload(['message' => 'Logged out succesfully !']);
	}
}