<?php

namespace Tests\Feature\Endpoints;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Resources\ChannelResource;
use App\Users\Domain\Collection\UserResource;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Resources\VideoResource;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserEndPointTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->actingAs(factory(User::class)->create());
	}
	/** @test */
	public function it_fetches_the_user_channels() {
		auth()->user()->channels()->saveMany(
			$channels = factory(Channel::class, 3)->create()
		);
		$resource = ChannelResource::collection($channels);
		$response = $this->get('/api/user/' . auth()->id() . '/channels');
		$response->assertResource($resource)->assertStatus(200);
		$this->assertCount(3, $response->baseResponse->getData()->data);
		$this->assertInstanceOf(Channel::class, $resource->response()->original->first()->resource);
	}
	/** @test */
	public function it_fetches_the_user_videos() {
		auth()->user()->channels()->save(
			$channel = factory(Channel::class)->create()
		);
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);
		auth()->user()->channels->first()->videos()->saveMany(
			$videos = factory(Video::class, 3)->create([
				'channel_id' => $channel->id,
			])
		);
		$this->assertCount(3, auth()->user()->videos);
		$resource = VideoResource::collection($videos);
		$response = $this->get('/api/user/' . auth()->id() . '/videos');
		$response->assertResource($resource);
	}
	/** @test */
	public function it_fetches_the_authenticated_user() {
		$user = factory(User::class)->create([
			'email' => 'mohammedosama@ieee.org',
			'password' => bcrypt(123456789),
		]);
		$user->load('channels');
		$resource = new UserResource($user);
		$token = auth()->guard('api')->attempt(['email' => $user->email, 'password' => 123456789]);
		$this->get('/api/user', ['Authorization' => "Bearer $token"])->assertStatus(200)->assertResource($resource);
		$this->assertCount(0, $resource->channels);
	}
	/** @test */
	public function it_logs_out_the_user_and_destroy_token() {
		$user = factory(User::class)->create([
			'email' => 'mohammedosama@ieee.org',
			'password' => bcrypt(123456789),
		]);
		$token = auth()->guard('api')->attempt(['email' => $user->email, 'password' => 123456789]);
		$this->assertEquals($token, auth()->guard('api')->getToken());
		$this->post('/api/auth/logout');
		$this->assertNull(auth()->guard('api')->getToken());
	}
	/** @test */
	public function it_registers_user() {
		$response = $this->post('/api/auth/register', [
			'email' => 'mohammedosama@ieee.org',
			'password' => 123456789,
			'password_confirmation' => 123456789,
			'name' => 'mohammedosama',
			'channel_name' => 'Laravel Testing',
		])->assertStatus(201)->assertJson(["data" => [
			"id" => 2,
			"name" => "mohammedosama",
			"email" => "mohammedosama@ieee.org",
			"avatar" => "http://www.gravatar.com/avatar/50aa51d8b081e89d5b382ba39435218c?s=45&d=mm",
		],
		]
		);
	}
	/** @test */
	public function it_logs_in_a_user() {
		$user = factory(User::class)->create([
			'password' => bcrypt(123456789),
		]);
		$resource = new UserResource($user);
		$this->post('/api/auth/login', [
			'email' => $user->email,
			'password' => 123456789,
		])->assertResource($resource);
		$response = $this->post('/api/auth/login', [
			'email' => $user->email,
		])->assertStatus(422)->assertJsonFragment(['password' => ["The password field is required."]]);
		$this->post('/api/auth/login', [
			'email' => $user->email,
			'password' => 12345678,

		])->assertJsonFragment(['error' => 'Could not authenticate user.']);
	}
	/** @test */
	public function it_forgots_user_password() {
		$user = factory(User::class)->create([
			'password' => bcrypt(123456789),
		]);
		$this->post('/api/auth/forgot-password', [
			'email' => null,
		])->assertJsonFragment(['email' => ["The email field is required."]])->assertStatus(422);
		$this->post('/api/auth/forgot-password', [
			'email' => $user->email,
		])->assertStatus(200)->assertJsonFragment([
			'message' => 'Kindly check your mail, ' . ucfirst($user->name)]);
		$emails = $this->app->make('swift.transport')->driver()->messages();
		$this->assertCount(1, $emails);
		$this->assertEquals([$user->email], array_keys($emails[0]->getTo()));
	}
	/** @test */
	public function it_resets_the_user_password() {
		$this->post('/api/auth/reset-password', [
			'password' => 123456789,
			'password_confirmation' => 123456789,
		])->assertStatus(422)->assertJsonFragment(['token' => ['The token field is required.']]);
		$user = factory(User::class)->create([
			'password' => bcrypt(123456789),
		]);
		$this->post('/api/auth/forgot-password', [
			'email' => $user->email,
		])->assertStatus(200)->assertJsonFragment([
			'message' => 'Kindly check your mail, ' . ucfirst($user->name)]);
		$token = \DB::table('password_resets')
			->where('email', $user->email)->first()->token;
		$this->post('/api/auth/reset-password', [
			'password' => 12345678910,
			'password_confirmation' => 12345678910,
			'token' => $token . '123456789',
		])->assertStatus(422)->assertJsonValidationErrors('token')->assertJson(['errors' => ['token' => ['Invalid Token']]]);
		$this->post('/api/auth/reset-password', [
			'password' => 12345678910,
			'password_confirmation' => 12345678910,
			'token' => $token,
		])->assertStatus(200)->assertJsonFragment(['message' => 'Password Changed Successfully !']);
		$this->assertTrue(auth()->attempt([
			'email' => $user->email,
			'password' => 12345678910,
		]));
	}
}
