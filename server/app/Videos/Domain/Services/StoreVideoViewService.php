<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Services\Service;
use Carbon\Carbon;

class StoreVideoViewService extends Service {
	const BUFFER = 30;
	protected $video = null;
	public function handle($request = null, $video = null) {
		$this->video = $video;
		if (!$video->canBeAccessed()) {
			return new UnauthorizedPayload;
		}
		if ($this->userWithinBuffer()) {
			return new GenericPayload;
		}
		if ($this->IpWithinBuffer()) {
			return new GenericPayload;
		}
		$video->views()->create([
			'user_id' => auth()->check() ? auth()->id() : null,
			'ip' => $request->ip(),

		]);
		return new GenericPayload([
			'views' => $video->views->count(),
		]);
	}
	protected function userWithinBuffer() {
		return auth()->check() && ($view = $this->video->views()->latestByUser(auth()->user())->first()) && $this->withinBuffer($view);
	}
	protected function IpWithinBuffer() {
		return $this->withinBuffer($this->video->views()->latestByIp(request()->ip())->first());
	}
	protected function withinBuffer($view) {
		return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
	}
}