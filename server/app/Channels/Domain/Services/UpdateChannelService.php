<?php

namespace App\Channels\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\UnauthorizedPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Channels\Domain\Jobs\UploadImage;
use App\Channels\Domain\Rules\ImageValidationRule;

class UpdateChannelService implements ServiceInterface {
	protected $channel;
	public function handle($request = [], $channel = null) {
		$this->channel = $channel;
		if (auth()->user()->cannot('update-channel', $this->channel)) {
			return new UnauthorizedPayload;
		}
		if (($validator = $this->validate($request->only(['avatar', 'slug', 'name'])))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		if ($request->has('avatar') && preg_match("/^data:image\/(.jpeg|jpg|png);base64/i", $request->avatar, $match)
		) {
			$image = $request->avatar; // your base64 encoded
			$image = str_replace('data:image/' . $match[1] . ';base64,', '', $image);
			$image = str_replace(' ', '+', $image);
			$imageName = uniqid('', true) . '.' . $match[1];
			\File::put(storage_path('app/public/images/') . $imageName, base64_decode($image));
			if (\File::extension(storage_path('app/public/images/') . $imageName) != $match[1]) {
				\File::delete(storage_path('app/public/images/') . $imageName);
			}
			dispatch(new UploadImage($channel, $imageName));
		}
		$channel->update($request->except(['avatar']));
		return new GenericPayload($channel);
	}
	public function validate($data) {
		return validator($data, [
			'name' => 'nullable|unique:channels,name,' . $this->channel->id,
			'slug' => 'nullable|unique:channels,slug,' . $this->channel->id,
			'avatar' => [
				'nullable',
				new ImageValidationRule,
			],
		]);
	}
}