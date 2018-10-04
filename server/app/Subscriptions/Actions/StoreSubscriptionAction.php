<?php

namespace App\Subscriptions\Actions;

use App\Channels\Domain\Models\Channel;
use App\Subscriptions\Domain\Services\StoreSubscriptionService;
use App\Subscriptions\Responders\StoreSubscriptionResponder;

class StoreSubscriptionAction {
	public function __construct(StoreSubscriptionResponder $responder, StoreSubscriptionService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($channel)
		)->respond();
	}
}