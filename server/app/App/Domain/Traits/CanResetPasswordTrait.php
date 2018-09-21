<?php

namespace App\App\Domain\Traits;

use App\App\Domain\Notifications\ResetPassword as ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;

/**
 * summary
 */
trait CanResetPasswordTrait {
	use CanResetPassword;
	public function createPasswordResetToken() {
		\DB::table('password_resets')->where('email', $this->email)->delete();
		\DB::table('password_resets')->insert([
			'email' => $this->email,
			'token' => str_random(60),
			'created_at' => Carbon::now(),
		]);
		return \DB::table('password_resets')
			->where('email', $this->email)->first();
	}
	public function validatePasswordResetToken($token) {
		return \DB::table('password_resets')
			->where('token', $token)->first();

	}
	public function destroyPasswordResetToken($token) {
		return \DB::table('password_resets')
			->where('token', $token)->delete();
	}
	public function retrieveUserThroughPasswordResetToken($token) {
		if ($token = $this->validatePasswordResetToken($token)) {
			return $this->whereEmail($token->email)->first();
		}
	}
	public function sendPasswordResetNotification($token) {
		$this->notify(new ResetPasswordNotification($token));
	}
}