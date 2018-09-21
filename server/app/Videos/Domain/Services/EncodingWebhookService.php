<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\Videos\Domain\Jobs\RemoveUploadedVideo;
use App\Videos\Domain\Repositories\VideoRepository;
use Illuminate\Http\Request;

class EncodingWebhookService implements ServiceInterface {
	protected $videos;
	public function __construct(VideoRepository $videos) {
		$this->videos = $videos;
	}
	public function handle($request = null) {
		$event = camel_case($request->event);
		if (method_exists($this, $event)) {
			$this->{$event}($request);
		}

	}
	protected function videoEncoded(Request $request) {
		$video = $this->getVideoByFilename($request->original_filename);
		if ($video->video_id != $request->encoding_ids[0] . '.mp4' || $video->thumbnail != $request->encoding_ids[1] . '.jpg') {
			$video->processed = true;
			$video->video_id = $request->encoding_ids[0] . '.mp4';
			$video->thumbnail = $request->encoding_ids[1] . '.jpg';
			$video->save();
		}
	}
	protected function videoCreated(Request $request) {
		$video = $this->getVideoByFilename($request->original_filename);
		dispatch(new RemoveUploadedVideo($video));
	}
	protected function encodingProgress(Request $request) {
		$video = $this->getVideoByFilename($request->original_filename);
		if ($video->processed_percentage != $request->progress) {
			$video->processed_percentage = $request->progress;
			$video->save();
		}
	}
	protected function getVideoByFilename($filename) {
		return $this->videos->where('video_filename', $filename)->firstOrFail();
	}
}