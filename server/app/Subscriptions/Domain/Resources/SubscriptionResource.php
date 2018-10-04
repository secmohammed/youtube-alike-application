<?php

namespace App\Subscriptions\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		return [
			'count' => $this->subscriptionCount(),
			'user_subscribed' => auth()->check() ? auth()->user()->isSubscribedTo($this->resource) : false,
			'can_subscribe' => auth()->check() ? !auth()->user()->ownsChannel($this->resource) : false,
		];
	}
}
