<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Channels\Domain\Jobs\UploadImage;
use App\Channels\Domain\Models\Channel;

class CreateChannelService implements ServiceInterface {
	public function handle($request = []) {
		if (($validator = $this->validate($request->only(['description', 'avatar', 'slug', 'name'])))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		$channel = auth()->user()->channels()->create($request->only(['avatar', 'slug', 'name', 'description']));
		$this->pushImageToStorage($request->avatar, $channel);
		dispatch(new UploadImage($channel));
		return new GenericPayload($channel);
	}
	protected function pushImageToStorage($file, Channel $channel) {
		$file->storeAs('images', $channel->avatar, [
			'disk' => 'public',
		]);
	}
	public function validate($data) {
		return validator($data, [
			'name' => 'required|unique:channels,name',
			'slug' => 'required|unique:channels,slug',
			'avatar' => 'required|mimes:png,jpeg,jpg',
			'description' => 'required',
		]);
	}

}