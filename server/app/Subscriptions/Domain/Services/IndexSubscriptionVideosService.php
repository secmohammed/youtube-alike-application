<?php

namespace App\Subscriptions\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Users\Domain\Repositories\UserRepository;

class IndexSubscriptionVideosService implements ServiceInterface {
	protected $subscriptions;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($data = []) {
		return new GenericPayload($this->users->videosFromSubscription(auth()->user()));
	}
}