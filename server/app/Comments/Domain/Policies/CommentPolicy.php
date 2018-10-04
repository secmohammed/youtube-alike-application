<?php

namespace App\Comments\Domain\Policies;

use App\Comments\Domain\Models\Comment;
use App\Users\Domain\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy {
	use HandlesAuthorization;

	public function delete(User $user, Comment $comment) {
		return $user->id == $comment->user_id;
	}
}
