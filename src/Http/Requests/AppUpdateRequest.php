<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppUpdateRequest extends FormRequest
{
	/**
	 * @return array<string,mixed[]>
	 */
	public function rules(): array
	{
		return [
			'title' => ['string', 'required', 'sometimes'],
			'meta' => ['array', 'nullable', 'sometimes'],
			'owner' => ['int', 'required', 'sometimes'],
		];
	}
}
