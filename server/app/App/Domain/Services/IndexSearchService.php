<?php

namespace App\App\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Channels\Domain\Repositories\ChannelRepository;

class IndexSearchService implements ServiceInterface {
	private $channels, $videos;

	public function __construct(ChannelRepository $channels) {
		$this->channels = $channels;
	}

	public function handle($request = null) {
		return new GenericPayload(
			$this->channels->search($request->q)->take(2)->get()
		);
	}
}