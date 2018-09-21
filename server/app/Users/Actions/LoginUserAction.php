<?php

namespace App\Users\Actions;

use App\Users\Domain\Services\LoginUserService;
use App\Users\Responders\LoginUserResponder;
use Illuminate\Http\Request;

class LoginUserAction {
	public function __construct(LoginUserService $services, LoginUserResponder $responder) {
		$this->services = $services;
		$this->responder = $responder;
	}
	public function __invoke(Request $request) {
		return $this->responder->withResponse(
			$this->services->handle($request->only(['email', 'password']))
		)->respond();
	}
}