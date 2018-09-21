<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Services\IndexUserChannelsService;
use App\Channels\Responders\IndexUserChannelsResponder;
use App\Users\Domain\Models\User;

class IndexUserChannelsAction {
	public function __construct(IndexUserChannelsResponder $responder, IndexUserChannelsService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(User $user) {
		return $this->responder->withResponse(
			$this->services->handle($user)
		)->respond();
	}
}