<?php

namespace App\Comments\Actions;

use App\Comments\Domain\Models\Comment;
use App\Comments\Domain\Services\DeleteCommentService;
use App\Comments\Responders\DeleteCommentResponder;
use App\Videos\Domain\Models\Video;

class DeleteCommentAction {
	public function __construct(DeleteCommentResponder $responder, DeleteCommentService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Video $video, Comment $comment) {
		return $this->responder->withResponse(
			$this->services->handle($video, $comment)
		)->respond();
	}
}