<?php

namespace App\App\Http\Middleware;

use Closure;

class ParseJWTToken {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (request()->headers->has('Authorization')) {
			\JWTAuth::parseToken()->authenticate();
		}
		return $next($request);
	}
}
