<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Users\Domain\Repositories\UserRepository;

class LoginUserService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($data = []) {
		if (($validator = $this->validate($data))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		if (!auth()->attempt($data)) {
			return new UnauthorizedPayload([
				'error' => 'Could not authenticate user.',
			]);
		}
		return new GenericPayload(auth()->user());
	}
	protected function validate($data) {
		return validator($data, [
			'email' => 'required|email',
			'password' => 'required|min:8|max:32',
		]);
	}
}