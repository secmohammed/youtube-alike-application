<?php

namespace Tests\Unit\Integration\Models;

use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Votes\Domain\Models\Vote;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VoteTest extends TestCase {
	public function setUp() {
		parent::setUp();
		auth()->login(factory(User::class)->create());
		$path = storage_path('app/public/videos/test.webm');
		$file = new UploadedFile($path, 'test.webm', "video/webm", null, true);
		request()->merge(['video_filename' => $file]);

		$this->video = factory(Video::class)->create();
	}
	/** @test */
	public function it_creates_a_new_vote_for_user() {
		$this->video->votes()->save(
			factory(Vote::class)->create([
				'voteable_id' => $this->video->id,
				'voteable_type' => 'videos',
				'user_id' => auth()->id(),

			])
		);

		$this->assertCount(1, $this->video->fresh()->votes);
	}
}