<?php

namespace App\Comments\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;

class DeleteCommentService implements ServiceInterface {
	public function handle($video = null, $comment = null) {
		if (auth()->user()->cannot('delete-comment', $comment)) {
			return new UnauthorizedPayload;
		}
		$comment->delete();
		return new GenericPayload(['message' => 'Comment Deleted Successfully']);
	}
}