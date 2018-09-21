<?php

namespace App\Users\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;

class ForgotUserPasswordResponder extends Responder implements ResponderInterface {
	public function respond() {
		if ($this->response->getStatus() !== 200) {
			return response()->json($this->response->getData(), $this->response->getStatus());
		}
		return response()->json($this->response->getData());
	}
}
