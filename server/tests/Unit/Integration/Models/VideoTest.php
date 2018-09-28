<?php

namespace Tests\Unit\Integration\Models;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Models\View;
use App\Votes\Domain\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VideoTest extends TestCase {
	public function setUp() {
		parent::setUp();
		auth()->login(factory(User::class)->create());
		$this->video = new Video;
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

	}
	/** @test */
	public function it_has_uid_as_route_key_name() {
		$this->assertEquals('uid', $this->video->getRouteKeyName());
	}
	/** @test */
	public function it_belongs_to_a_specific_channel() {
		$channel = factory(Channel::class)->create();
		$channel->videos()->saveMany(
			factory(Video::class, 3)->create()
		);
		$this->assertInstanceOf(Channel::class, $this->video->first()->channel);
		$this->assertCount(3, $this->video->first()->channel->videos);
	}
	/** @test */
	public function it_fetches_latest_first() {

		factory(Video::class, 3)->create();
		$latest = factory(Video::class)->create([
			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
		]);
		$this->assertEquals($latest->created_at, $this->video->latestFirst()->first()->created_at);
	}
	/** @test */
	public function it_has_many_views() {
		factory(Video::class, 3)->create();
		$this->video->first()->views()->saveMany(
			factory(View::class, 3)->create([
				'user_id' => auth()->id(),
				'video_id' => $this->video->first()->id,
			])
		);
		$this->assertCount(3, $this->video->first()->fresh()->views);
		$this->assertEquals(3, $this->video->first()->fresh()->viewCount());
	}
	/** @test */
	public function it_has_a_private_visibility() {
		$video = factory(Video::class)->create(['visibility' => 'private']);
		$this->assertTrue($video->isPrivate());
	}
	/** @test */
	public function it_is_self_owned_video() {
		$channel = factory(Channel::class)->create();
		$video = $channel->videos()->save(factory(Video::class)->create(['visibility' => 'private']));
		$this->assertTrue($video->selfOwned());
		auth()->logout();
		$this->assertFalse($video->selfOwned());
		auth()->login(factory(User::class)->create());
		$this->assertFalse($video->selfOwned());

	}
	/** @test */
	public function it_can_access_videos_under_conditions() {
		$channel = factory(Channel::class)->create();
		$video = $channel->videos()->save(factory(Video::class)->create(['visibility' => 'private']));
		$this->assertTrue($video->canBeAccessed());
		$video->update([
			'visibility' => 'public',
		]);
		$this->assertTrue($video->canBeAccessed());
		$this->assertTrue($video->canBeAccessed(
			factory(User::class)->create()
		));

		$video->update([
			'visibility' => 'unlisted',
		]);
		$this->assertTrue($video->canBeAccessed());
		auth()->logout();
		$this->assertTrue($video->canBeAccessed());
		$this->assertTrue($video->canBeAccessed(
			factory(User::class)->create()
		));
		$video->update([
			'visibility' => 'private',
		]);
		$this->assertFalse($video->canBeAccessed());
		$this->assertFalse($video->canBeAccessed(
			factory(User::class)->create()
		));
	}
	/** @test */
	public function it_has_many_morphed_votes() {
		$channel = factory(Channel::class)->create();
		$video = $channel->videos()->save(factory(Video::class)->create(['visibility' => 'private']));
		$video->votes()->saveMany(
			factory(Vote::class, 3)->create([
				'voteable_id' => $video->id,
				'voteable_type' => 'videos',
			])
		);
		$video->votes()->saveMany(
			factory(Vote::class, 3)->create([
				'voteable_id' => $video->id,
				'voteable_type' => 'videos',
				'type' => false,
			])

		);
		$this->assertCount(3, $video->downVotes()->get());
		$this->assertCount(3, $video->upVotes()->get());
	}
	/** @test */
	public function it_fetches_recent_user_votes() {
		$channel = factory(Channel::class)->create();
		$video = $channel->videos()->save(factory(Video::class)->create());
		$video->votes()->saveMany(
			factory(Vote::class, 3)->create([
				'voteable_id' => $video->id,
				'voteable_type' => 'videos',
			])
		);
		$this->assertEquals(3, $video->voteFromUser(auth()->user())->count());
	}
	/** @test */
	public function it_has_votes_allowed() {
		$channel = factory(Channel::class)->create();
		$video = $channel->videos()->save(factory(Video::class)->create());

		$this->assertTrue($video->votesAllowed());
	}
}