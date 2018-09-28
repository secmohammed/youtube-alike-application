<?php

namespace Tests\Feature\Endpoints;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Jobs\RemoveEncodedVideo;
use App\Videos\Domain\Jobs\UploadVideo;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Resources\VideoResource;
use App\Votes\Domain\Models\Vote;
use App\Votes\Domain\Resources\VoteResource;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VideoEndPointTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->user = factory(User::class)->create();
		$this->channel = factory(Channel::class)->create();
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

	}
	/** @test */
	public function it_shows_a_speicifc_video() {
		auth()->login($this->user);
		$video = $this->channel->videos()->save(
			factory(Video::class)->create()
		);
		$resource = new VideoResource($video);
		$this->get('/api/videos/' . $video->uid)->assertResource($resource)->assertStatus(200);
		$video->update([
			'visibility' => 'private',
		]);
		$this->get('/api/videos/' . $video->uid)->assertStatus(200);
		auth()->logout();
		$this->get('/api/videos/' . $video->uid)->assertStatus(401);
		$video->update(['visibility' => 'public']);
		$this->get('/api/videos/' . $video->uid)->assertStatus(200);
		auth()->login(factory(User::class)->create());
		$this->get('/api/videos/' . $video->uid)->assertStatus(200);
		$video->update(['visibility' => 'private']);
		$this->get('/api/videos/' . $video->uid)->assertStatus(401);
	}
	/** @test */
	public function it_logs_a_view_to_the_video_through_ip() {
		$video = $this->channel->videos()->save(
			factory(Video::class)->create()
		);
		$this->post('/api/videos/' . $video->uid . '/views')->assertStatus(200)->assertJsonFragment(['views' => 1]);
		$this->post('/api/videos/' . $video->uid . '/views')->assertStatus(200)->assertJsonFragment([]);
	}
	/** @test */
	public function it_logs_a_view_to_the_video_through_user_id() {
		$video = $this->channel->videos()->save(
			factory(Video::class)->create()
		);

		auth()->login(factory(User::class)->create());
		$response = $this->post('/api/videos/' . $video->uid . '/views')->assertStatus(200)->assertJsonFragment(['views' => 1]);
		$this->assertEquals($response->getData()->views, $video->fresh()->views->count());
		$this->post('/api/videos/' . $video->uid . '/views')->assertStatus(200)->assertJsonFragment([]);

	}
	/** @test */
	public function it_shows_the_vote_of_a_video() {

		$video = $this->channel->videos()->save(
			factory(Video::class)->create()
		);
		$resource = new VoteResource($video);
		$this->get('/api/videos/' . $video->uid . '/votes')->assertResource($resource);
		$video->votes()->saveMany(
			factory(Vote::class, 3)->create([
				'voteable_id' => $video->id,
				'voteable_type' => 'videos',
			])
		);
		$resource = new VoteResource($video->fresh());
		$this->get('/api/videos/' . $video->uid . '/votes')->assertResource($resource);
		auth()->login(factory(User::class)->create());
		$video->votes()->save(
			factory(Vote::class)->create([
				'user_id' => auth()->id(),
				'voteable_id' => $video->id,
				'voteable_type' => 'videos',

			])
		);
		$resource = new VoteResource($video->fresh());
		$this->get('/api/videos/' . $video->uid . '/votes')->assertResource($resource)->assertJsonFragment(['user_vote' => true]);
	}
	/** @test */
	public function it_deletes_a_video() {
		$video = $this->channel->videos()->save(
			factory(Video::class)->create()
		);
		$this->delete('/api/videos/' . $video->uid)->assertStatus(401);
		auth()->login(factory(User::class)->create());
		$this->delete('/api/videos/' . $video->uid, [], [
			'Authorization' => 'Bearer ' . auth()->getToken(),
		])->assertStatus(401);
		auth()->logout();
		auth()->login(User::first());
		\Queue::fake();
		\Storage::fake('s3storage');
		$this->delete('/api/videos/' . $video->uid, [], [
			'Authorization' => 'Bearer ' . auth()->getToken(),
		])->assertStatus(200)->assertJsonFragment(['message' => 'Video has been deleted successfully !']);
		\Queue::assertPushed(RemoveEncodedVideo::class);
	}
	/** @test */
	public function it_lets_user_create_a_video() {
		\Queue::fake();
		\Storage::fake('public');
		\Storage::fake('s3videos');
		auth()->login($this->user);
		$response = $this->post('/api/videos/' . $this->channel->slug, [
			'video_filename' => UploadedFile::fake()->create('laravel.mp4', 1024),
			'title' => 'laravel tip',
			'description' => 'dummy description about laravel.',
			'visibility' => 'public',
			'allow_comments' => true,
			'allow_votes' => true,
		], [
			'Authorization' => 'Bearer ' . auth()->getToken(),
		])->assertStatus(201)->assertJsonFragment([
			'title' => 'laravel tip',
			'description' => 'dummy description about laravel.',
		]);
		\Queue::assertPushed(UploadVideo::class);
	}
	/** @test */
	public function it_lets_user_update_a_video() {
		\Queue::fake();
		\Storage::fake('public');
		\Storage::fake('s3videos');

		$video = $this->channel->videos()->save(
			factory(Video::class)->create([
				'thumbnail' => 'default.png',
			])
		);
		$this->post('/api/videos/' . $video->uid . '/update', [
			'channel_id' => $video->channel->id,
		])->assertStatus(401);
		$channel = factory(Channel::class)->create();
		auth()->login(factory(User::class)->create());
		$this->post('/api/videos/' . $video->uid . '/update', [
			'channel_id' => $channel->id,
		], [
			'Authorization' => 'Bearer ' . auth()->getToken(),
		])->assertStatus(401);
		auth()->login($this->user);

		$response = $this->post('/api/videos/' . $video->uid . '/update', [
			'channel_id' => $channel->id,
		], [
			'Authorization' => 'Bearer ' . auth()->getToken(),

		])->assertStatus(200)->assertResource(new VideoResource($video->fresh()));
		\Queue::assertNotPushed(RemoveEncodedVideo::class);
		\Queue::assertNotPushed(UploadVideo::class);
		$response = $this->post('/api/videos/' . $video->uid . '/update', [
			'channel_id' => $channel->id,
			'video_filename' => UploadedFile::fake()->create('laravel.mp4', 1024 * 1024),
		], [
			'Authorization' => 'Bearer ' . auth()->getToken(),

		])->assertStatus(200)->assertResource(new VideoResource($video->fresh()));
		\Queue::assertPushed(RemoveEncodedVideo::class);
		\Queue::assertPushed(UploadVideo::class);
		$this->post('/api/videos/' . $video->uid . '/update', [
			'video_filename' => UploadedFile::fake()->create('laravel.mp4', 1024 * 1024),
		], [
			'Authorization' => 'Bearer ' . auth()->getToken(),

		])->assertStatus(422)->assertJsonValidationErrors('channel_id')->assertJsonFragment(['errors' => ['channel_id' => ['The channel id field is required.']]]);
	}
}
?>