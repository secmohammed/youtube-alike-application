<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Videos\Domain\Jobs\RemoveEncodedVideo;
use App\Videos\Domain\Jobs\UploadVideo;

class UpdateVideoService implements ServiceInterface {
	protected $video;
	public function handle($request = [], $video = null) {
		if (auth()->user()->cannot('update-video', $video)) {
			return new UnauthorizedPayload;
		}
		if (($validator = $this->validate($request->only(['title', 'description', 'allow_comments', 'allow_votes', 'visibility', 'channel_id', 'video_filename'])))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		$this->video = $video;
		if ($request->has('video_filename')) {
			$this->pushVideoToStorage($request->video_filename);
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
	protected function validate($data) {
		$channel_ids = implode(',', auth()->user()->channels()->pluck('id')->toArray());
		return validator($data, [
			'title' => 'nullable',
			'description' => 'nullable',
			'visibility' => 'nullable|in:private,unlisted,public',
			'video_filename' => 'nullable|mimes:webm,mp4,mkv',
			'channel_id' => 'required|in:' . $channel_ids,
			'allow_votes' => 'nullable|boolean',
			'allow_comments' => 'nullable|boolean',
		]);
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