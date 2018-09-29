<?php

namespace App\Comments\Domain\Resources;

use App\Users\Domain\Collection\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'id' => $this->id,
			'uid' => $this->when(!$this->reply_id, $this->commentable->uid),
			'user' => new UserResource($this->user),
			$this->mergeWhen($this->replies->count() && !$this->reply_id, [
				'replies' => CommentResource::collection($this->replies()->latestFirst()->get()),
			]),
			'body' => $this->body,
			'created_at_human' => $this->created_at->diffForHumans(),
			'updated_at_human' => $this->updated_at->diffForHumans(),

		];
	}
}
