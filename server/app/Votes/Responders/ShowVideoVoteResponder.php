<?php

namespace App\Votes\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Votes\Domain\Resources\VoteResource;

class ShowVideoVoteResponder extends Responder implements ResponderInterface {
	public function respond() {
		if ($this->response->getStatus() != 200) {
			return response()->json($this->response->getData(), $this->response->getStatus());
		}
		return new VoteResource($this->response->getData());
	}
}
