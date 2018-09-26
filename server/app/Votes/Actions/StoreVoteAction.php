<?php

namespace App\Votes\Actions;

use App\Votes\Domain\Services\StoreVoteService;
use App\Votes\Responders\StoreVoteResponder;

class StoreVoteAction {
    public function __construct(StoreVoteResponder $responder, StoreVoteService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}