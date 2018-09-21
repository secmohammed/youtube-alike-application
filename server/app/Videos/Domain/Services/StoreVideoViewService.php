<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\UnauthorizedPayload;

class StoreVideoViewService implements ServiceInterface {
	public function handle($request = null, $video = null) {
		if (!$video->canBeAccessed(auth()->user())) {
			return new UnauthorizedPayload;
		}
		$video->views()->create([
			'user_id' => auth()->check() ? auth()->id() : null,
			'ip' => $requet->ip(),

		]);
		return new GenericPayload([
			'views' => $video->views->count(),
		]);
	}
}