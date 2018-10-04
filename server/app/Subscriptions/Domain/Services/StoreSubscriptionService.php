<?php

namespace App\Subscriptions\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;

class StoreSubscriptionService implements ServiceInterface {
	public function handle($channel = null) {
		if (auth()->user()->cannot('subscribe-this-channel', $channel)) {
			return new UnauthorizedPayload;
		}
		auth()->user()->subscriptions()->create([
			'channel_id' => $channel->id,
		]);

		return new GenericPayload([
			'message' => $channel->name . ' has been subscribed to',
			'success' => true,
		]);
	}
}