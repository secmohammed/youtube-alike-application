<?php

namespace App\Users\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;

class LogoutUserResponder extends Responder implements ResponderInterface {
	public function respond() {
		return response()->json($this->response->getData());
	}
}
