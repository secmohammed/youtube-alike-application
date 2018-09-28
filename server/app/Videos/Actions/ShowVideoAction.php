<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Services\ShowVideoService;
use App\Videos\Responders\ShowVideoResponder;

class ShowVideoAction {
	public function __construct(ShowVideoResponder $responder, ShowVideoService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($video)
		)->respond();
	}
}