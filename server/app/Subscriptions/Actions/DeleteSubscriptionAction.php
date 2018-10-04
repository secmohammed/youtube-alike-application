<?php

namespace App\Subscriptions\Actions;

use App\Channels\Domain\Models\Channel;
use App\Subscriptions\Domain\Services\DeleteSubscriptionService;
use App\Subscriptions\Responders\DeleteSubscriptionResponder;

class DeleteSubscriptionAction {
	public function __construct(DeleteSubscriptionResponder $responder, DeleteSubscriptionService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($channel)
		)->respond();
	}
}