<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Users\Domain\Repositories\UserRepository;

class IndexUserChannelsService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($user = []) {
		$user->channels->load('user');
		return new GenericPayload($user->channels);
	}
}