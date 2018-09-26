<?php

namespace App\Votes\Domain\Repositories;

use App\App\Domain\Repositories\Repository;
use App\Votes\Domain\Models\Vote;

class VoteRepository extends Repository {
    protected $model;
    public function __construct(Vote $vote) {
        $this->model = $vote;
    }
}
