<?php

namespace App\Channels\Domain\Observers;

use App\Channels\Domain\Models\Channel;

class ChannelObserver {

	public function updating(Channel $channel) {
		foreach ($channel->getFillable() as $fillable) {
			$channel->$fillable = $channel->getAttributes()[$fillable] ?? $channel->getOriginal($fillable);
		}
	}
}