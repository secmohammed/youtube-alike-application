<?php

namespace App\Channels\Domain\Policies;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy {
	use HandlesAuthorization;

	public function update(User $user, Channel $channel) {
		return $user->id == $channel->user->id;
	}
}
