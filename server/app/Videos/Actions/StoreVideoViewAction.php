<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Services\StoreVideoViewService;
use App\Videos\Responders\StoreVideoViewResponder;
use Illuminate\Http\Request;

class StoreVideoViewAction {
	public function __construct(StoreVideoViewResponder $responder, StoreVideoViewService $services) {
		$this->responder = $responder;
		$this->services = $services;
		if (request()->headers->has('Authorization')) {
			\JWTAuth::parseToken()->authenticate();
		}
	}
	public function __invoke(Request $request, Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($request, $video)
		)->respond();
	}
}