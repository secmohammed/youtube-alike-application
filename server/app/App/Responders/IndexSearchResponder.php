<?php

namespace App\App\Responders;

use App\App\Responders\Responder;
use App\App\Responders\ResponderInterface;
use App\Channels\Domain\Resources\ChannelResource;
use App\Videos\Domain\Repositories\VideoRepository;
use App\Videos\Domain\Resources\VideoResource;

class IndexSearchResponder extends Responder implements ResponderInterface {
	protected $videos;
	public function __construct(VideoRepository $videos) {
		$this->videos = $videos;
	}
	public function respond() {
		return ChannelResource::collection($this->response->getData())->additional([
			'videos' => VideoResource::collection($this->videos->search(request('q'))->take(10)->get()),
		]);
	}
}
