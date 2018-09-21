<?php

namespace App\Videos\Domain\Observers;

use App\Videos\Domain\Models\Video;

class VideoObserver {
	public function creating(Video $video) {
		$video->uid = $uid = uniqid('', true);
		$video->video_filename = $uid . '.' . request()->file('video_filename')->getClientOriginalExtension();
	}
	public function updating(Video $video) {
		foreach ($video->getFillable() as $fillable) {
			$video->$fillable = $video->getAttributes()[$fillable] ?? $video->getOriginal($fillable);
		}
	}
}