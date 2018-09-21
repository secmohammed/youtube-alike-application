<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Services\DeleteVideoService;
use App\Videos\Responders\DeleteVideoResponder;

class DeleteVideoAction {
	public function __construct(DeleteVideoResponder $responder, DeleteVideoService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video) {
		return $this->responder->withResponse(
			$this->services->handle($video)
		)->respond();
	}
}