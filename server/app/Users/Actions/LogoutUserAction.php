<?php

namespace App\Users\Actions;

use App\Users\Domain\Services\LogoutUserService;
use App\Users\Responders\LogoutUserResponder;

class LogoutUserAction {
    public function __construct(LogoutUserResponder $responder, LogoutUserService $services) {
        $this->responder = $responder;
        $this->services = $services;
    }
    public function __invoke() {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}