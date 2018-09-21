<?php

namespace App\Users\Actions;

use App\Users\Domain\Services\AuthorizedUserService;
use App\Users\Responders\AuthorizedUserResponder;

class AuthorizedUserAction {
	public function __construct(AuthorizedUserResponder $responder, AuthorizedUserService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke() {
		return $this->responder->withResponse(
			$this->services->handle()
		)->respond();
	}
}