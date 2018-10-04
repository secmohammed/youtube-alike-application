<?php

namespace App\Subscriptions\Actions;

use App\Channels\Domain\Models\Channel;
use App\Subscriptions\Domain\Services\ShowSubscriptionService;
use App\Subscriptions\Responders\ShowSubscriptionResponder;

class ShowSubscriptionAction {
	public function __construct(ShowSubscriptionResponder $responder, ShowSubscriptionService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($channel)
		)->respond();
	}
}