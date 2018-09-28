<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Channels\Domain\Jobs\RemoveUploadedImage;
use App\Channels\Domain\Jobs\UploadImage;

class UpdateChannelService extends CreateChannelService implements ServiceInterface {
	protected $channel;
	public function handle($request = [], $channel = null) {
		$this->channel = $channel;
		if (auth()->user()->cannot('update-channel', $this->channel)) {
			return new UnauthorizedPayload;
		}
		if (($validator = $this->validate($request->only(['avatar', 'slug', 'name', 'description'])))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		$channel->update($request->only(['avatar', 'slug', 'name', 'description']));
		if ($request->has('avatar')) {
			$this->pushImageToStorage($request->avatar, $channel);
			dispatch(new RemoveUploadedImage($channel));
			dispatch(new UploadImage($channel));
		}
		return new GenericPayload($channel);
	}
	public function validate($data) {
		return validator($data, [
			'name' => 'nullable|unique:channels,name,' . $this->channel->id,
			'slug' => 'nullable|unique:channels,slug,' . $this->channel->id,
			'description' => 'nullable',
			'avatar' => 'nullable|mimes:png,jpg,jpeg',
		]);
	}
}