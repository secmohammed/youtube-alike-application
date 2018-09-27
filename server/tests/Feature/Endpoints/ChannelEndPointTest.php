<?php

namespace Tests\Feature\Endpoints;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Resources\ChannelResource;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Resources\VideoResource;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ChannelEndPointTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->user = factory(User::class)->create();
		$this->channel = factory(Channel::class)->create();
	}
	/** @test */
	public function it_shows_a_specific_channel() {
		$this->get('/api/channel/some-random-channel')->assertStatus(404);
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

		$this->channel->videos()->saveMany(
			factory(Video::class, 3)->create()
		);

		$resource = new ChannelResource($this->channel);
		$this->get('/api/channel/' . $this->channel->slug)->assertStatus(200)->assertResource($resource);
	}
	/** @test */
	public function it_fetches_the_channel_videos() {
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

		$this->channel->videos()->saveMany(
			factory(Video::class, 3)->create()
		);
		$resource = VideoResource::collection($this->channel->videos);
		$response = $this->get('/api/channel/' . $this->channel->slug . '/videos')->assertResource($resource);
	}
	/** @test */
	public function it_updates_a_channel() {
		\Storage::fake('avatars');
		$anotherUser = factory(User::class)->create();
		auth()->guard('api')->login($anotherUser);
		$this->put('/api/channel/' . $this->channel->slug, [
			'name' => 'something-really-random',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
		])->assertStatus(401);
		auth()->guard('api')->login($this->user);
		$this->put('/api/channel/' . $this->channel->slug, [
			'name' => 'something-really-random',
		])->assertStatus(200)->assertJsonFragment(['name' => 'something-really-random']);
	}
}