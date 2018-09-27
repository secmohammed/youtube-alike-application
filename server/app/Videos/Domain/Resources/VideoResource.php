<?php

namespace App\Videos\Domain\Resources;

use App\Channels\Domain\Resources\ChannelResource;
use App\Users\Domain\Collection\UserResource;
use App\Votes\Domain\Resources\VoteResource;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'uid' => $this->uid,
			'description' => $this->description,
			'title' => $this->title,
			'channel' => $this->whenLoaded('channel', new ChannelResource($this->channel)),
			'thumbnail' => config('codetube.buckets.storage') . '/' . $this->thumbnail,
			'views' => $this->views->count(),
			'owned' => $this->selfOwned(),
			'user_id' => $this->channel->user_id,
			'processed' => !!$this->processed,
			'video_url' => $this->when($this->video_id, config('codetube.buckets.storage') . '/' . $this->video_id),
			'processed_percentage' => $this->when(!$this->processed && $this->processed_percentage, $this->processed_percentage),
			'allow_comments' => $this->allow_comments,
			'allow_votes' => $this->allow_votes,
			'video_filename' => $this->video_filename,
			$this->mergeWhen($this->allow_votes, [
				'votes' => new VoteResource($this->resource),
			]),
			'created_at_human' => $this->created_at->diffForHumans(),
			'user' => new UserResource($this->channel->user),
		];
	}
}
