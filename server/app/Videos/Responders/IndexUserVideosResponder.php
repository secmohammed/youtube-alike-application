<?php

namespace App\Videos\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Videos\Domain\Resources\VideoResource;

class IndexUserVideosResponder extends Responder implements ResponderInterface {
	public function respond() {
		$this->response->getData()->load('channel');
		return VideoResource::collection($this->response->getData());
	}
}
