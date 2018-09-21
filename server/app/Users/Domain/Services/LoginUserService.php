<?php

namespace App\Users\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Users\Domain\Repositories\UserRepository;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginUserService implements ServiceInterface {
	protected $users;
	public function __construct(UserRepository $users) {
		$this->users = $users;
	}
	public function handle($data = []) {
		if (($validator = $this->validate($data))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		try {
			$token = JWTAuth::attempt($data, [
				'exp' => Carbon::now()->addWeek()->timestamp,
			]);
		} catch (JWTException $e) {
			return new InternalErrorPayload([
				'error' => 'Could not create token.',
			]);
		}
		if (!$token) {
			return new UnauthorizedPayload([
				'error' => 'Could not authenticate user.',
			]);
		}
		return new GenericPayload(auth()->user());
	}
	protected function validate($data) {
		return validator($data, [
			'email' => 'required',
			'password' => 'required',
		]);
	}
}