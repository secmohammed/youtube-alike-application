<?php

namespace Tests\Unit\Integration\Models;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->actingAs(factory(User::class)->create());
	}
	/** @test */
	public function it_has_many_channels() {
		auth()->user()->channels()->saveMany(factory(Channel::class, 3)->create([
			'user_id' => auth()->id(),
		]));
		$this->assertCount(3, auth()->user()->channels);
	}
	/** @test */
	public function it_has_videos_through_channels() {
		auth()->user()->channels()->save(
			$channel = factory(Channel::class)->create(
				[
					'user_id' => auth()->id(),
				])
		);
		$channel = factory(Channel::class)->create();
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

		auth()->user()->channels->first()->videos()->saveMany(
			factory(Video::class, 3)->create([
				'channel_id' => $channel->id,
			])
		);
		$this->assertCount(3, auth()->user()->videos);
	}
	/** @test */
	public function it_has_id_as_jwt_identifier() {
		$this->assertEquals(auth()->id(), auth()->user()->getJWTIdentifier());
	}
	/** @test */
	public function it_creates_password_reset_tokens() {
		$this->assertInstanceOf('stdClass', auth()->user()->createPasswordResetToken());
	}
	/** @test */
	public function it_has_a_valid_token() {
		$token = auth()->user()->createPasswordResetToken()->token;
		$this->assertEquals($token, auth()->user()->validatePasswordResetToken($token)->token);
	}
	/** @test */
	public function it_destroys_a_token() {
		$token = auth()->user()->createPasswordResetToken()->token;
		$this->assertEquals(1, auth()->user()->destroyPasswordResetToken($token));
	}
	/** @test */
	public function it_retrieves_user_through_password_reset_token() {
		$token = auth()->user()->createPasswordResetToken()->token;
		$this->assertInstanceOf(User::class, auth()->user()->retrieveUserThroughPasswordResetToken($token));
	}
}
