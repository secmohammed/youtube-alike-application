<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Users\Domain\Repositories\UserRepository;

class ForgotUserPasswordService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($request = []) {
		if (($validator = $this->validate($request))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		$user = $this->users->whereEmail($request['email'])->first();
		$user->sendPasswordResetNotification($user->createPasswordResetToken()->token);
		return new GenericPayload([
			'message' => 'Kindly check your mail, ' . ucfirst($user->name),
		]);
	}
	protected function validate($data) {
		return validator($data, [
			'email' => 'required|exists:users,email',
		]);
	}

}