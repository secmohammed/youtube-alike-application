<?php

namespace App\Users\Actions;

use App\Users\Domain\Services\ForgotUserPasswordService;
use App\Users\Responders\ForgotUserPasswordResponder;
use Illuminate\Http\Request;

class ForgotUserPasswordAction {
	public function __construct(ForgotUserPasswordResponder $responder, ForgotUserPasswordService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request) {
		return $this->responder->withResponse(
			$this->services->handle($request->only(['email']))
		)->respond();
	}
}