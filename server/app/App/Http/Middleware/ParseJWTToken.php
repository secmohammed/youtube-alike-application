<?php

namespace App\App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class ParseJWTToken {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		try {
			if ($this->checkIfUserHasToken()) {
				JWTAuth::parseToken()->authenticate();
			}
		} catch (TokenExpiredException $e) {
			// If the token is expired, then it will be refreshed and added to the headers
			try {
				$this->refreshUserToken();
			} catch (JWTException $e) {
				return response()->json($e->getMessage());
			}
		} catch (JWTException $e) {
			return response()->json($e->getMessage());
		}
		return $next($request);
	}
	protected function checkIfUserHasToken() {
		if ($this->isAuthenticatedWithoutHeader()) {
			$this->setAuthorizationHeader();
		}
		return request()->headers->has('Authorization');
	}
	protected function refreshUserToken() {
		auth()->setToken(auth()->refresh());
		$this->setAuthorizationHeader();
	}
	protected function isAuthenticatedWithoutHeader() {
		return auth()->check() && !request()->headers->has('Authorization');
	}
	protected function setAuthorizationHeader() {
		request()->headers->set('Authorization', 'Bearer ' . auth()->getToken());

	}
}
