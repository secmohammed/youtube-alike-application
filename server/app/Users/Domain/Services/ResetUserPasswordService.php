<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Users\Domain\Repositories\UserRepository;

class ResetUserPasswordService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($request = []) {
		if (($validator = $this->validate($request))->fails()) {
			return new ValidationPayload($validator->errors());
		}

		$user = $this->users->retrieveUserThroughPasswordResetToken($request['token']);
		$user->update([
			'password' => bcrypt($request['password']),
		]);
		$user->destroyPasswordResetToken($request['token']);
		return new GenericPayload([
			'message' => 'Password Changed Successfully !',
		]);
	}
	protected function validate($data) {
		return validator($data, [
			'password' => 'required|min:8|confirmed',
			'token' => 'required|exists:password_resets,token',
		], [
			'token.exists' => 'Invalid Token',
		]);
	}
}