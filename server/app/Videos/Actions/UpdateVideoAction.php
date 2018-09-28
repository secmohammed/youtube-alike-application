<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Services\UpdateVideoService;
use App\Videos\Responders\UpdateVideoResponder;
use Illuminate\Http\Request;

class UpdateVideoAction {
	public function __construct(UpdateVideoResponder $responder, UpdateVideoService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request, Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($request, $video)
		)->respond();
	}
}