<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppSearchRequest extends FormRequest
{
	/**
	 * @return array<string,mixed[]>
	 */
	public function rules(): array
	{
		return [
			'title' => ['string', 'required', 'sometimes'],
			'owner' => ['int','required', 'sometimes'],
		];
	}
}
