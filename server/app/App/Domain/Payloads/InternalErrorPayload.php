<?php

namespace App\App\Domain\Payloads;

class InternalErrorPayload extends Payload {
	protected $status = 500;
}