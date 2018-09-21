<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Channels\Domain\Repositories\ChannelRepository;

class ShowChannelService implements ServiceInterface {
	protected $channels;
	public function __construct(ChannelRepository $channels) {
		$this->channels = $channels;
	}
	public function handle($channel = []) {
		return new GenericPayload($channel);
	}
}