<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Services\CreateChannelService;
use App\Channels\Responders\CreateChannelResponder;

class CreateChannelAction {
    public function __construct(CreateChannelResponder $responder, CreateChannelService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}