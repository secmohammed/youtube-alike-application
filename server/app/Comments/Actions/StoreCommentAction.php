<?php

namespace App\Comments\Actions;

use App\Comments\Domain\Services\StoreCommentService;
use App\Comments\Responders\StoreCommentResponder;

class StoreCommentAction {
    public function __construct(StoreCommentResponder $responder, StoreCommentService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}