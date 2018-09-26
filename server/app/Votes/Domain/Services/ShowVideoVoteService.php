<?php

namespace App\Votes\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\Votes\Domain\Repositories\VoteRepository;

class ShowVideoVoteService implements ServiceInterface {
	protected $votes;
	public function __construct(VoteRepository $votes) {
		$this->votes = $votes;
	}
	public function handle($video = null) {
		if (!$video->canBeAccessed()) {
			return new UnauthorizedPayload;
		}
		return new GenericPayload($video);
	}
}