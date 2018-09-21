<?php

namespace App\Videos\Actions;

use App\Channels\Domain\Models\Channel;
use App\Videos\Domain\Requests\CreateVideoRequest;
use App\Videos\Domain\Services\CreateVideoService;
use App\Videos\Responders\CreateVideoResponder;

class CreateVideoAction {
	public function __construct(CreateVideoResponder $responder, CreateVideoService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(CreateVideoRequest $request, Channel $channel) {
		return $this->responder->withResponse(
			$this->services->handle($request, $channel)
		)->respond();
	}
}