<?php

namespace App\Videos\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return auth()->user()->can('update-video', request()->route('video'));
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$channel_ids = auth()->user()->channels()->pluck('id');
		return [
			'title' => 'nullable',
			'description' => 'nullable',
			'visibility' => 'nullable|in:private,unlisted,public',
			'video_filename' => 'nullable|mimes:webm,mp4,mkv',
			// 'channel_id' => 'required|in:' . $channel_ids,
		];
	}
}
