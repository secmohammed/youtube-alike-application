<?php

namespace App\Videos\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;

class IndexVideoResponder extends Responder implements ResponderInterface {
	public function respond() {
		$this->response->getData()->load('channel');
	}
}
