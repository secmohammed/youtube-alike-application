<?php

namespace App\Videos\Domain\Jobs;

use App\Videos\Domain\Models\Video;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Storage;

class UploadVideo implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $video, $path;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Video $video) {
		$this->video = $video;
		$this->path = storage_path('app/public/videos/' . $this->video->video_filename);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {

		if (Storage::disk('s3videos')->put('videos/' . $this->video->video_filename, fopen($this->path, 'r+'))) {
			File::delete($this->path);
		}
	}
}
