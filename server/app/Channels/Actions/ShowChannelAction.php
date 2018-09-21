<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Services\ShowChannelService;
use App\Channels\Responders\ShowChannelResponder;

class ShowChannelAction {
	public function __construct(ShowChannelResponder $responder, ShowChannelService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($channel)
		)->respond();
	}
}