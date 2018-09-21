<?php

namespace App\Videos\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Videos\Domain\Resources\VideoResource;

class CreateVideoResponder extends Responder implements ResponderInterface {
	public function respond() {
		$this->response->getData()->load('channel');
		return new VideoResource($this->response->getData());
	}
}
