<?php

namespace App\Subscriptions\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Videos\Domain\Resources\VideoResource;

class IndexSubscriptionVideosResponder extends Responder implements ResponderInterface {
	public function respond() {
		return VideoResource::collection($this->response->getData());
	}
}
