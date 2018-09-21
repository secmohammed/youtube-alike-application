<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Users\Domain\Repositories\UserRepository;

class ResetUserPasswordService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($request = []) {
		$user = $this->users->retrieveUserThroughPasswordResetToken($request['token']);
		$user->update([
			'password' => bcrypt($request['password']),
		]);
		$user->destroyPasswordResetToken($request['token']);
		return new GenericPayload([
			'message' => 'Password Changed Successfully !',
		]);
	}
}