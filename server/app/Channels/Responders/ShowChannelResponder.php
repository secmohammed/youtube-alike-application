<?php

namespace App\Channels\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Channels\Domain\Resources\ChannelResource;

class ShowChannelResponder extends Responder implements ResponderInterface {
	public function respond() {
		return new ChannelResource($this->response->getData());
	}
}
