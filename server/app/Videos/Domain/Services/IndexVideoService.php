<?php

namespace App\Videos\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\Videos\Domain\Repositories\VideoRepository;
class IndexVideoService implements ServiceInterface {
    protected $videos;
    public function __construct(VideoRepository $videos) {
        $this->videos = $videos;
    }
    public function handle($data = []) {
        return new GenericPayload($this->videos->all());
    }
}