<?php

namespace App\Users\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Users\Domain\Collection\UserResource;

class AuthorizedUserResponder extends Responder implements ResponderInterface {
	public function respond() {
		return new UserResource($this->response->getData());
	}
}
