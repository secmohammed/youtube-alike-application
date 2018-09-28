<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Services\CreateChannelService;
use App\Channels\Responders\CreateChannelResponder;
use Illuminate\Http\Request;

class CreateChannelAction {
	public function __construct(CreateChannelResponder $responder, CreateChannelService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request) {

		return $this->responder->withResponse(
			$this->services->handle($request)
		)->respond();
	}
}