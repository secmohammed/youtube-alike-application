<?php

namespace App\Channels\Domain\Repositories;

use App\App\Domain\Repositories\Repository;
use App\Channels\Domain\Models\Channel;

class ChannelRepository extends Repository {
    protected $model;
    public function __construct(Channel $channel) {
        $this->model = $channel;
    }
}
