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
		$anotherUser = factory(User::class)->create();
		auth()->guard('api')->login($anotherUser);
		$this->put('/api/channel/' . $this->channel->slug, [
			'name' => 'something-really-random',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
		])->assertStatus(401);
		auth()->guard('api')->login($this->user);
		\Queue::fake();
		$this->assertNull($this->channel->fresh()->avatar);
		$this->put('/api/channel/' . $this->channel->slug, [
			'name' => 'something-really-random',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
		], ['Authorization' => 'Bearer ' . auth()->guard('api')->getToken()])->assertStatus(200)->assertJsonFragment(['name' => 'something-really-random']);
		$this->assertNotNull($this->channel->fresh()->avatar);
		\Queue::assertPushed(\App\Channels\Domain\Jobs\UploadImage::class);
	}
	/** @test */
	public function it_creates_a_channel() {
		\Queue::fake();
		auth()->guard('api')->login($this->user);
		$this->post('/api/channel', [
			'name' => 'laravel-random-channel',
			'slug' => 'laravel-dummy-channel-test',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
			'description' => 'a quick laravel test',
		], ['Authorization' => 'Bearer ' . auth()->guard('api')->getToken()])->assertStatus(201)->assertJsonFragment([
			'name' => 'laravel-random-channel',
			'slug' => 'laravel-dummy-channel-test',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
		])->assertJsonStructure(['data' => ['created_at_human', 'updated_at_human']]);
		$channel = Channel::whereName('laravel-random-channel')->first();
		\Queue::assertPushed(\App\Channels\Domain\Jobs\UploadImage::class, function ($job) use ($channel) {
			return $job->channel->avatar == $channel->avatar;
		});
		$this->assertEquals(auth()->id(), $channel->user_id);
		$this->post('/api/channel', [
			'name' => 'laravel-random-channel',
			'slug' => 'laravel-dummy-channel-test',
			'avatar' => UploadedFile::fake()->image('avatar.jpg'),
		], ['Authorization' => 'Bearer ' . auth()->guard('api')->getToken()])->assertStatus(422)->assertJsonValidationErrors(['name', 'slug', 'description'])->assertJsonFragment(['description' => ["The description field is required."], 'name' => ['The name has already been taken.'], 'slug' => ["The slug has already been taken."]]);
	}
	/** @test */
	public function it_indexes_the_channels() {
		$resource = ChannelResource::collection(Channel::paginate(8, ['*'])->setPath(config('app.url') . '/api/channel'));
		$this->get('/api/channel')->assertResource($resource);
	}
}