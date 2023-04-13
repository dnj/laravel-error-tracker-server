<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppStoreRequest extends FormRequest
{
    /**
     * @return array<string,mixed[]>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'required'],
            'meta' => ['array', 'nullable'],
            'owner' => ['int', 'required'],
        ];
    }
}
