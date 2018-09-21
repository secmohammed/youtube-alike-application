<?php

namespace App\Users\Actions;

use App\Users\Domain\Requests\ResetUserPasswordRequest;
use App\Users\Domain\Services\ResetUserPasswordService;
use App\Users\Responders\ResetUserPasswordResponder;

class ResetUserPasswordAction {
	public function __construct(ResetUserPasswordResponder $responder, ResetUserPasswordService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(ResetUserPasswordRequest $request) {
		return $this->responder->withResponse(
			$this->services->handle($request->validated())
		)->respond();
	}
}