<?php

namespace Tests\Unit;

use App\App\Http\Middleware\ParseJWTToken;
use App\Users\Domain\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class ParseJWTTokenMiddlewareTest extends TestCase {
	/** @test */
	public function it_pushes_authorization_header_to_the_request() {
		auth()->login(factory(User::class)->create());
		$response = \Mockery::mock(Request::class)->shouldReceive('header')->with('authorization', 'Bearer ' . auth()->getToken());
		$request = Request::create('/api/user', 'GET');
		$middleware = new ParseJWTToken;
		$middleware->handle($request, function () use ($response) {
			return $response;
		});
		auth()->logout();
		// $request = Request::create('/api/user', 'GET');
		// dd($request->headers);
		// $middleware = new ParseJWTToken;
		// $middleware->handle($request, function () use ($response) {
		// 	return $response;
		// });

	}
}
