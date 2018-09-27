<?php

namespace App\Users\Actions;

use App\Users\Domain\Services\ResetUserPasswordService;
use App\Users\Responders\ResetUserPasswordResponder;
use Illuminate\Http\Request;

class ResetUserPasswordAction {
	public function __construct(ResetUserPasswordResponder $responder, ResetUserPasswordService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request) {
		return $this->responder->withResponse(
			$this->services->handle($request->only('password', 'password_confirmation', 'token'))
		)->respond();
	}
}