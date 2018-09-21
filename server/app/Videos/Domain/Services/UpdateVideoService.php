<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\Videos\Domain\Jobs\RemoveEncodedVideo;
use App\Videos\Domain\Jobs\UploadVideo;

class UpdateVideoService implements ServiceInterface {
	protected $video;
	public function handle($request = [], $video = null) {
		if (auth()->user()->cannot('update-video', $video)) {
			return new UnauthorizedPayload;
		}
		$this->video = $video;
		if ($request->hasFile('video_filename')) {
			$this->pushVideoToStorage($request->file('video_filename'));
			dispatch(new RemoveEncodedVideo($this->video));
			dispatch(new UploadVideo($this->video));
		}
		$this->video->update(
			$request->only([
				'title', 'description', 'channel_id', 'visibility', 'allow_comments', 'allow_votes',
			])
		);
		return new GenericPayload($this->video);
	}
	protected function pushVideoToStorage($file) {
		$file->storeAs('videos', $name = uniqid('', true) . '.' . $file->getClientOriginalExtension(), [
			'disk' => 'public',
		]);
		$this->video->update([
			'video_filename' => $name,
			'thumbnail' => config('codetube.buckets.image'),
			'processed' => false,
			'video_id' => null,
		]);
	}
}