<?php

namespace App\Videos\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;

class DeleteVideoResponder extends Responder implements ResponderInterface {
	public function respond() {
		return response()->json($this->response->getData(), $this->response->getStatus());

	}
}
