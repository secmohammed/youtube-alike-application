<?php

namespace App\Subscriptions\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Subscriptions\Domain\Resources\SubscriptionResource;

class ShowSubscriptionResponder extends Responder implements ResponderInterface {
	public function respond() {
		return new SubscriptionResource($this->response->getData());
	}
}
