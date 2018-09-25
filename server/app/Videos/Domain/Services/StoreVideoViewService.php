<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Services\Service;

class StoreVideoViewService extends Service {
	public function handle($request = null, $video = null) {
		if (!$video->canBeAccessed()) {
			return new UnauthorizedPayload;
		}
		$video->views()->create([
			'user_id' => auth()->check() ? auth()->id() : null,
			'ip' => $request->ip(),

		]);
		return new GenericPayload([
			'views' => $video->views->count(),
		]);
	}
}