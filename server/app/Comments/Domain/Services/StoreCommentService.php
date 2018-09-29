<?php

namespace App\Comments\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Comments\Domain\Repositories\CommentRepository;
class StoreCommentService implements ServiceInterface {
    protected $comments;
    public function __construct(CommentRepository $comments) {
        $this->comments = $comments;
    }
    public function handle($data = []) {
        return new GenericPayload($this->comments->all());
    }
}