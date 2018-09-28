<?php

namespace App\Votes\Actions;

use App\Videos\Domain\Models\Video;
use App\Votes\Domain\Services\ShowVideoVoteService;
use App\Votes\Responders\ShowVideoVoteResponder;

class ShowVideoVoteAction {
	public function __construct(ShowVideoVoteResponder $responder, ShowVideoVoteService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($video)
		)->respond();
	}
}