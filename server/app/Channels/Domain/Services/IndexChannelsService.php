<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Channels\Domain\Repositories\ChannelRepository;

class IndexChannelsService implements ServiceInterface {
	protected $channels;
	public function __construct(ChannelRepository $channels) {
		$this->channels = $channels;
	}
	public function handle($data = []) {
		return new GenericPayload($this->channels->all());
	}
}