<?php

namespace App\Comments\Actions;

use App\Comments\Domain\Services\IndexCommentsService;
use App\Comments\Responders\IndexCommentsResponder;
use App\Videos\Domain\Models\Video;

class IndexCommentsAction {
	public function __construct(IndexCommentsResponder $responder, IndexCommentsService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($video)
		)->respond();
	}
}