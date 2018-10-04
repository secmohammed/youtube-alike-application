<?php

namespace App\Comments\Domain\Services;

use App\App\Domain\Contracts\ServiceInterface;
use App\App\Domain\Payloads\GenericPayload;
use App\App\Domain\Payloads\ValidationPayload;
use App\Videos\Domain\Models\Video;

class StoreCommentService implements ServiceInterface {
	public function handle($request = [], Video $video = null) {
		if (($validator = $this->validate($request->only(['body', 'reply_id'])))->fails()) {
			return new ValidationPayload($validator->errors());
		}
		return new GenericPayload($video->comments()->create([
			'body' => $request->body,
			'commentable_id' => $video->id,
			'user_id' => auth()->id(),
			'reply_id' => $request->reply_id,
		]));
	}
	protected function validate($data) {
		return validator($data, [
			'reply_id' => 'nullable|exists:comments,id',
			'body' => 'required|min:3|max:250',
		]);
	}
}