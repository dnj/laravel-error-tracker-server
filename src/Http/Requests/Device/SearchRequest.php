<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'nullable'],
            'user' => ['int', 'nullable'],
            'owner' => ['int', 'nullable'],
        ];
    }
}
