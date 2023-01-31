<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'extra' => ['array'],
            'owner' => ['integer'],
            'userActivityLog' => ['nullable', 'boolean'],
        ];
    }
}
