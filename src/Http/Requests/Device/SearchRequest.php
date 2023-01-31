<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'nullable'],
            'extra' => ['int', 'array'],
            'owner' => ['int', 'nullable'],
        ];
    }
}
