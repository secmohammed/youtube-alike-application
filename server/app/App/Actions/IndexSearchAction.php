<?php

namespace App\App\Actions;

use App\App\Domain\Services\IndexSearchService;
use App\App\Responders\IndexSearchResponder;
use Illuminate\Http\Request;

class IndexSearchAction {
	public function __construct(IndexSearchResponder $responder, IndexSearchService $services) {
		$this->responder = $responder;
		$this->services = $services;
	}
	public function __invoke(Request $request) {
		return $this->responder->withResponse(
			$this->services->handle($request)
		)->respond();
	}
}