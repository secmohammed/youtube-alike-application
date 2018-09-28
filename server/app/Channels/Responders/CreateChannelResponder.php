<?php

namespace App\Channels\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Channels\Domain\Resources\ChannelResource;

class CreateChannelResponder extends Responder implements ResponderInterface {
	public function respond() {
		if ($this->response->getStatus() != 200) {
			return response()->json($this->response->getData(), $this->response->getStatus());
		}
		return new ChannelResource($this->response->getData());
	}
}
