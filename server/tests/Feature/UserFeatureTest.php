<?php

namespace Tests\Feature;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Resources\ChannelResource;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Resources\VideoResource;
use Tests\TestCase;

class UserFeatureTest extends TestCase {
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
}
