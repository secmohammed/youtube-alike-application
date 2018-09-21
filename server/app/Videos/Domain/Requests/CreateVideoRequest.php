<?php

namespace App\Videos\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVideoRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return auth()->user()->channels->contains(request()->route('channel'));
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'title' => 'required|min:8|max:40',
			'description' => 'required|min:8|max:500',
			'visibility' => 'required|in:private,unlisted,public',
			'video_filename' => 'required|mimes:webm,mp4,mkv',
		];
	}
}
