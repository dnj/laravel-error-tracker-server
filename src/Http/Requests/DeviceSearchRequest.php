<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceSearchRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'title' => ['string', 'required', 'sometimes'],
			'owner' => ['int','required', 'sometimes'],
		];
	}
}
