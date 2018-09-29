<?php

namespace App\Votes\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Votes\Domain\Resources\VoteResource;

class DeleteVideoVoteResponder extends Responder implements ResponderInterface {
	public function respond() {
		return new VoteResource($this->response->getData());
	}
}
