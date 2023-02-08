<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\App;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'extra' => ['nullable', 'array'],
            'owner' => ['nullable', 'integer'],
        ];
    }
}
