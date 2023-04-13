<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'required'],
            'extra' => ['array', 'nullable'],
            'owner' => ['integer', 'nullable'],
        ];
    }
}
