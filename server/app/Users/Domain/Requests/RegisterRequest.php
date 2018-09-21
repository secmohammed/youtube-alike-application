<?php

namespace App\Users\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
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
			'name' => 'required|unique:users,name',
			'email' => 'required|unique:users,email',
			'password' => 'required|confirmed',
			'channel_name' => 'required|unique:channels,name|max:255',
		];
	}
}
