<?php

namespace App\Channels\Domain\Resources;

use App\Users\Domain\Collection\UserResource;
use App\Videos\Domain\Resources\VideoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'name' => $this->name,
			'id' => $this->id,
			'slug' => $this->slug,
			'description' => $this->description,
			'avatar' => config('codetube.buckets.storage') . '/profile/' . $this->avatar ?? 'default.png',
			'user' => new UserResource($this->whenLoaded('user')),
			'videos' => $this->when($this->conditionallyLoadFilteredVideos(), $this->conditionallyLoadFilteredVideos()),
			'created_at_human' => $this->created_at->diffForHumans(),
			'updated_at_human' => $this->updated_at->diffForHumans(),
			'views' => $this->totalVideoViews(),
			'subscriptions' => $this->subscriptionCount(),
		];
	}
	protected function when($condition, $value, $default = null) {
		if ($condition instanceof Illuminate\Http\Resources\Json\AnonymousResourceCollection && $condition->collection) {
			return value($value);
		}
		if ($condition instanceof Illuminate\Support\Collection && $condition->count()) {
			return value($value);
		}
		if ($condition && !$condition instanceof Illuminate\Http\Resources\Json\AnonymousResourceCollection && !$condition instanceof Illuminate\Support\Collection) {
			return value($value);
		}
		return func_num_args() === 3 ? value($default) : new Illuminate\Http\Resources\MissingValue;
	}
	protected function conditionallyLoadFilteredVideos() {
		if (request()->route('video') && ($collection = VideoResource::collection($this->whenLoaded('videos'))->collection)) {
			return $collection->where('uid', '!=', request()->route('video')->uid);

		}
		return VideoResource::collection($this->whenLoaded('videos'));
	}
}
