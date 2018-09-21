<?php

namespace App\Videos\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Videos\Domain\Resources\VideoResource;

class ShowVideoResponder extends Responder implements ResponderInterface {
	public function respond() {
		if ($this->response->getStatus() != 200) {
			return response()->json($this->response->getData(), $this->response->getStatus());
		}
		$this->response->getData()->load('channel.videos');
		return (new VideoResource($this->response->getData()));
	}
}
