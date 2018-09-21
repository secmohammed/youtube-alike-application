<?php

namespace Tests\Unit\Integration\Models;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use Tests\TestCase;

class ChannelTest extends TestCase {
	public function setUp() {
		parent::setUp();
		$this->actingAs(factory(User::class)->create());
		$this->channel = new Channel;
	}
	/** @test */
	public function it_has_slug_as_route_key_name() {
		$this->assertEquals('slug', $this->channel->getRouteKeyName());
	}
	/** @test */
	public function it_belongs_to_a_user() {
		$channel = factory(Channel::class)->create();
		$this->assertInstanceOf(User::class, $channel->user);
	}
	/** @test */
	public function it_has_many_videos() {
		$channel = factory(Channel::class)->create();

		$channel->videos()->saveMany(
			factory(Video::class, 3)->create([
				'channel_id' => $channel->id,
			])
		);
		$this->assertCount(3, $channel->videos);
	}
}