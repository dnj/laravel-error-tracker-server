<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Log;

use dnj\ErrorTracker\Contracts\LogLevel;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'apps' => ['array', 'nullable'],
            'apps.*' => ['exists:apps,id'],

            'devices' => ['array', 'nullable'],
            'devices.*' => ['exists:devices,id'],

            'levels' => ['array', 'nullable'],
            'levels.*' => sprintf('in:%s', implode(',', getEnumValues(LogLevel::cases()))),

            'message' => ['string', 'nullable'],
            'unread' => ['bool', 'nullable'],
            'user' => ['int', 'nullable'],
        ];
    }
}