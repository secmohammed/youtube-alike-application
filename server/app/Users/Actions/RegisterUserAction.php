<?php

namespace App\Users\Actions;

use App\Users\Domain\Requests\RegisterRequest;
use App\Users\Domain\Services\RegisterUserService;
use App\Users\Responders\RegisterUserResponder;

class RegisterUserAction {
	public function __construct(RegisterUserService $services, RegisterUserResponder $responder) {
		$this->services = $services;
		$this->responder = $responder;
	}
	public function __invoke(RegisterRequest $request) {
		return $this->responder->withResponse(
			$this->services->handle($request->validated())
		)->respond();
	}
}