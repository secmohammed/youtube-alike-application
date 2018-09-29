<?php

namespace App\Votes\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Videos\Domain\Models\Video;

class DeleteVideoVoteService implements ServiceInterface {
	public function handle($video = null) {
		$video->votes()->byUser()->updateOrCreate([
			'user_id' => auth()->id(),
			'voteable_id' => $video->id,
			'voteable_type' => Video::class,
		], [
			'type' => false,
		]);
		return new GenericPayload($video);
	}
}