<?php

namespace App\Channels\Domain\Observers;

use App\Channels\Domain\Models\Channel;
use Illuminate\Http\UploadedFile;

class ChannelObserver {
	public function creating(Channel $channel) {
		if (request()->avatar) {
			$channel->avatar = uniqid('', true) . '.' . request()->avatar->getClientOriginalExtension();

		}
	}
	public function updating(Channel $channel) {
		foreach ($channel->getFillable() as $fillable) {
			if ($channel->avatar instanceof UploadedFile) {
				$channel->avatar = $channel->getOriginal('avatar') ?? uniqid('', true) . '.' . $channel->avatar->getClientOriginalExtension();
			} else {
				$channel->$fillable = $channel->getAttributes()[$fillable] ?? $channel->getOriginal($fillable);
			}
		}
	}
}