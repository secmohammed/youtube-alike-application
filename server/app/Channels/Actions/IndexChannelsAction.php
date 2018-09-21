<?php

namespace App\Channels\Actions;

use App\Channels\Domain\Services\IndexChannelsService;
use App\Channels\Responders\IndexChannelsResponder;

class IndexChannelsAction {
    public function __construct(IndexChannelsResponder $responder, IndexChannelsService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}