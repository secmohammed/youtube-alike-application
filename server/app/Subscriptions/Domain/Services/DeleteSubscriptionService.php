<?php

namespace App\Subscriptions\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\Subscriptions\Domain\Repositories\SubscriptionRepository;

class DeleteSubscriptionService implements ServiceInterface {
	protected $subscriptions;
	public function __construct(SubscriptionRepository $subscriptions) {
		$this->subscriptions = $subscriptions;
	}
	public function handle($channel = null) {
		if (auth()->user()->cannot('unsubscribe-this-channel', $channel)) {
			return new UnauthorizedPayload;
		}

		auth()->user()->subscriptions()->where([
			'channel_id' => $channel->id,
		])->delete();
		return new GenericPayload([
			'message' => $channel->name . ' has been unsubscribed to',
			'success' => true,
		]);
	}
}