<?php

namespace App\Comments\Domain\Repositories;

use App\App\Domain\Repositories\Repository;
use App\Comments\Domain\Models\Comment;

class CommentRepository extends Repository {
    protected $model;
    public function __construct(Comment $comment) {
        $this->model = $comment;
    }
}
