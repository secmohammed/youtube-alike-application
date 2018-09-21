<?php

namespace App\Channels\Domain\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageValidationRule implements Rule {
	// 2mb.
	const ALLOWED_SIZE = 2 * 1024;

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value) {
		return preg_match("/^data:image\/(.jpeg|jpg|png);base64/i", $value) && ((int) (strlen(rtrim($value, '=')) * 3 / 4) / 1024 <= self::ALLOWED_SIZE);
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return 'That is not an allowed mime, sorry !';
	}
}
