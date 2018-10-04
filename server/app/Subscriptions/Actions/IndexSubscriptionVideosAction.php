<?php

namespace App\Subscriptions\Actions;

use App\Subscriptions\Domain\Services\IndexSubscriptionVideosService;
use App\Subscriptions\Responders\IndexSubscriptionVideosResponder;

class IndexSubscriptionVideosAction {
    public function __construct(IndexSubscriptionVideosResponder $responder, IndexSubscriptionVideosService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}