<?php

namespace App\Channels\Domain\Jobs;

use App\Channels\Domain\Models\Channel;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Image;
use Storage;

class UploadImage implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $channel, $fileName;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Channel $channel, $fileName) {
		$this->channel = $channel;
		$this->fileName = $fileName;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		$path = storage_path('app/public/images/' . $this->fileName);
		Image::make($path)->encode('png')->fit(40, 40, function ($constraint) {
			$constraint->upsize();
		})->save($path);
		if (Storage::disk('s3storage')->put('profile/' . $this->fileName, fopen($path, 'r+'))) {
			File::delete($path);
		}
		$this->channel->avatar = $this->fileName;
		$this->channel->save();
	}
}
