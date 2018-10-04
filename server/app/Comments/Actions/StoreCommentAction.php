<?php

namespace App\Comments\Actions;

use App\Comments\Domain\Services\StoreCommentService;
use App\Comments\Responders\StoreCommentResponder;
use App\Videos\Domain\Models\Video;
use Illuminate\Http\Request;

class StoreCommentAction {
	public function __construct(StoreCommentResponder $responder, StoreCommentService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request, Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($request, $video)
		)->respond();
	}
}