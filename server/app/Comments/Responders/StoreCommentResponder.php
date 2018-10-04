<?php

namespace App\Comments\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Comments\Domain\Resources\CommentResource;

class StoreCommentResponder extends Responder implements ResponderInterface {
	public function respond() {
		if ($this->response->getStatus() != 200) {
			return response()->json($this->response->getData(), $this->response->getStatus());
		}
		return new CommentResource($this->response->getData());
	}
}
