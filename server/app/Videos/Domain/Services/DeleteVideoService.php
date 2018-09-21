<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\Videos\Domain\Jobs\RemoveEncodedVideo;

class DeleteVideoService implements ServiceInterface {
	public function handle($video = null) {
		if (auth()->user()->cannot('delete-video', $video)) {
			return new UnauthorizedPayload;
		}
		dispatch(new RemoveEncodedVideo($video));
		$video->delete();
		return new GenericPayload([
			'message' => 'Video has been deleted successfully !',
		]);
	}
}