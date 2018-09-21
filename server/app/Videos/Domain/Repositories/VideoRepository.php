<?php

namespace App\Videos\Domain\Repositories;

use App\App\Domain\Repositories\Repository;
use App\Videos\Domain\Models\Video;

class VideoRepository extends Repository {
    protected $model;
    public function __construct(Video $video) {
        $this->model = $video;
    }
}
