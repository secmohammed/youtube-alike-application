<?php

namespace App\Votes\Domain\Resources;

use App\Users\Domain\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource {

	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'user_vote' => auth()->check() ? $this->voteFromUser(auth()->user())->first()->type ?? null : null,
			'can_vote' => $this->votesAllowed(),
			$this->mergeWhen($this->votesAllowed(), [
				'up' => $this->upVotes()->count(),
				'down' => $this->downVotes()->count(),

			]),
		];
	}
}
