<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;

class ShowVideoService implements ServiceInterface {
	public function handle($video = null) {
		auth()->loginUsingId(1);
		// checks and alerts here.
		if (!$video->canBeAccessed()) {
			return new UnauthorizedPayload;
		}
		return new GenericPayload($video);
	}
}