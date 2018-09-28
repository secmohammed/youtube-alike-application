<?php

namespace App\Votes\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;

class ShowVideoVoteService implements ServiceInterface {
	public function handle($video = null) {
		if (!$video->canBeAccessed()) {
			return new UnauthorizedPayload;
		}
		return new GenericPayload($video);
	}
}