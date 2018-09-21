<?php

namespace App\Users\Domain\Collection;

use App\Channels\Domain\Resources\ChannelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'avatar' => $this->avatar(),
			'channels' => ChannelResource::collection($this->whenLoaded('channels')),
		];
	}
}
