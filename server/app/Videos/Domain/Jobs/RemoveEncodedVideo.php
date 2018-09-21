<?php

namespace App\Videos\Domain\Jobs;

use App\Videos\Domain\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class RemoveEncodedVideo implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $video;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Video $video) {
		$this->video = $video;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		Storage::disk('s3storage')->delete($this->video->video_id);
		Storage::disk('s3storage')->delete($this->video->thumbnail);
	}
}
