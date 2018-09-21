<?php

namespace App\Videos\Actions;

use App\Videos\Domain\Services\EncodingWebhookService;
use Illuminate\Http\Request;

class EncodingWebhookAction {
	protected $services;
	public function __construct(EncodingWebhookService $services) {
		$this->services = $services;
	}
	public function __invoke(Request $request) {
		$this->services->handle($request);
	}
}