<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Services\IndexVideoService;
use App\Videos\Responders\IndexVideoResponder;

class IndexVideoAction {
    public function __construct(IndexVideoResponder $responder, IndexVideoService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}