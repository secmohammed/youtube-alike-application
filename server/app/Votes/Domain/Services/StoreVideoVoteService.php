<?php

namespace App\Votes\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Videos\Domain\Models\Video;

class StoreVideoVoteService implements ServiceInterface {
	public function handle($video = null) {
		$video->votes()->byUser()->firstOrCreate([
			'user_id' => auth()->id(),
			'voteable_id' => $video->id,
			'voteable_type' => Video::class,
			'type' => true,
		]);
		return new GenericPayload($video);
	}
}