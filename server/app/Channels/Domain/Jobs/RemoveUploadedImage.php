<?php

namespace App\Channels\Domain\Jobs;

use App\Channels\Domain\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveUploadedImage implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	public $channel;
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Channel $channel) {
		$this->channel = $channel;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle() {
		\Storage::disk('s3storage')->delete('profile/' . $this->channel->avatar);
	}
}
