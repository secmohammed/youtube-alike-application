<?php

namespace App\Videos\Actions;

use App\Users\Domain\Models\User;
use App\Videos\Domain\Services\IndexUserVideosService;
use App\Videos\Responders\IndexUserVideosResponder;

class IndexUserVideosAction {
	public function __construct(IndexUserVideosResponder $responder, IndexUserVideosService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(User $user) {
		return $this->responder->withResponse(
			$this->services->handle($user)
		)->respond();
	}
}