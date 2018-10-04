<?php

namespace App\Subscriptions\Domain\Repositories;

use App\App\Domain\Repositories\Repository;
use App\Subscriptions\Domain\Models\Subscription;

class SubscriptionRepository extends Repository {
    protected $model;
    public function __construct(Subscription $subscription) {
        $this->model = $subscription;
    }
}
