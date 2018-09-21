<?php

namespace App\Channels\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChannelRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'name' => 'required|unique:channels,name,' . request()->route('channel')->id,
			'slug' => 'required|unique:channels,slug,' . request()->route('channel')->id,
		];
	}
}
