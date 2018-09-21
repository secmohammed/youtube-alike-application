<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Users\Domain\Repositories\UserRepository;

class RegisterUserService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($data = []) {
		$channel_name = $data['channel_name'];
		array_forget($data, 'channel_name');
		$user = $this->users->create(array_merge($data, ['password' => bcrypt($data['password'])]));
		$user->channels()->create([
			'name' => $channel_name,
			'slug' => uniqid('', true),
		]);
		return new GenericPayload($user);
	}
}