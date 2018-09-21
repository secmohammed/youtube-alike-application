<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Models\Channel;
use App\Channels\Domain\Services\UpdateChannelService;
use App\Channels\Responders\UpdateChannelResponder;
use Illuminate\Http\Request;

class UpdateChannelAction {
	public function __construct(UpdateChannelResponder $responder, UpdateChannelService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request, Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($request, $channel)
		)->respond();
	}
}