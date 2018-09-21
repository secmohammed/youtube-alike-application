<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Services\ShowChannelVideosService;
use App\Channels\Responders\ShowChannelVideosResponder;

class ShowChannelVideosAction {
	public function __construct(ShowChannelVideosResponder $responder, ShowChannelVideosService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($channel)
		)->respond();
	}
}