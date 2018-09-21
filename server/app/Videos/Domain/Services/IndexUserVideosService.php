<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class IndexUserVideosService implements ServiceInterface {
	public function handle($user = null) {
		return new GenericPayload($user->videos);
	}
}