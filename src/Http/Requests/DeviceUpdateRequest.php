<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceUpdateRequest extends FormRequest
{
    /**
     * @return array<string,mixed[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'nullable', 'sometimes'],
            'meta' => ['array', 'nullable', 'sometimes'],
            'owner' => ['int', 'nullable', 'sometimes'],
        ];
    }
}
