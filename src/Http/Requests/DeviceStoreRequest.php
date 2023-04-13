<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceStoreRequest extends FormRequest
{
    /**
     * @return array<string,mixed[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'nullable'],
            'meta' => ['array', 'nullable'],
            'owner' => ['int', 'nullable'],
        ];
    }
}
