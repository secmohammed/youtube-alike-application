<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class ShowChannelVideosService implements ServiceInterface {
	public function handle($channel = null) {
		return new GenericPayload($channel->videos()->visible()->get());
	}
}