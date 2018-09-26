<?php

namespace App\Votes\Actions;

use App\Votes\Domain\Services\StoreVideoVoteService;
use App\Votes\Responders\StoreVideoVoteResponder;

class StoreVideoVoteAction {
	public function __construct(StoreVideoVoteResponder $responder, StoreVideoVoteService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke() {
		return $this->responder->withResponse(
			$this->services->handle()
		)->respond();
	}
}