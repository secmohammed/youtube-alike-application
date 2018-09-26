<?php

namespace App\Votes\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Votes\Domain\Repositories\VoteRepository;
class StoreVoteService implements ServiceInterface {
    protected $votes;
    public function __construct(VoteRepository $votes) {
        $this->votes = $votes;
    }
    public function handle($data = []) {
        return new GenericPayload($this->votes->all());
    }
}