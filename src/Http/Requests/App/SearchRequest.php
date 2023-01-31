<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'nullable'],
            'owner' => ['int', 'nullable'],
            'user' => ['int', 'nullable'],
        ];
    }
}
