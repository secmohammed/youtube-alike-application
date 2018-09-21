<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Videos\Domain\Jobs\UploadVideo;
use App\Videos\Domain\Repositories\VideoRepository;

class CreateVideoService implements ServiceInterface {
	protected $videos;
	public function __construct(VideoRepository $videos) {
		$this->videos = $videos;
	}
	public function handle($request = [], $channel = null) {
		$video = $channel->videos()->create($request->except('video_filename'));
		$this->pushVideoToStorage($video, $request->file('video_filename'));
		dispatch(new UploadVideo($video));
		return new GenericPayload($video);
	}
	protected function pushVideoToStorage($video, $file) {
		$file->storeAs('videos', $video->video_filename, [
			'disk' => 'public',
		]);
	}
}