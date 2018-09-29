<?php

namespace App\Votes\Actions;

use App\Videos\Domain\Models\Video;
use App\Votes\Domain\Services\DeleteVideoVoteService;
use App\Votes\Responders\DeleteVideoVoteResponder;

class DeleteVideoVoteAction {
	public function __construct(DeleteVideoVoteResponder $responder, DeleteVideoVoteService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($video)
		)->respond();
	}
}