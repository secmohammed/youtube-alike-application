<?php

namespace App\Subscriptions\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;

class ShowSubscriptionService implements ServiceInterface {
	public function handle($channel = null) {
		return new GenericPayload($channel);
	}
}