<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class AuthorizedUserService implements ServiceInterface {
	public function handle($data = []) {
		auth()->user()->load('channels');
		return new GenericPayload(auth()->user());
	}
}
