<?php

namespace App\Comments\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class IndexCommentsService implements ServiceInterface {
	public function handle($video = null) {
		return new GenericPayload($video->comments()->latestFirst()->get());
	}
}