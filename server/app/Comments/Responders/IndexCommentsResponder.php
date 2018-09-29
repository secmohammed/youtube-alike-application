<?php

namespace App\Comments\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Comments\Domain\Resources\CommentResource;

class IndexCommentsResponder extends Responder implements ResponderInterface {
	public function respond() {
		return CommentResource::collection($this->response->getData());
	}
}
