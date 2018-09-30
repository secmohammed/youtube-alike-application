<?php

namespace App\Videos\Domain\Policies;

use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy {
	use HandlesAuthorization;

	public function update(User $user, Video $video) {
		return $user->id == $video->channel->user_id;
	}
	public function destroy(User $user, Video $video) {
		return $user->id == $video->channel->user_id;
	}
	public function access( ? User $user, Video $video) {
		return $video->canBeAccessed($user);
	}
	public function vote(User $user, Video $video) {
		return (!$video->canBeAccessed($user) || !$video->votesAllowed()) ? false : true;
	}
	public function comment(User $user, Video $video) {
		return (!$video->canBeAccessed($user) || !$video->commentsAllowed()) ? false : true;
	}
}
