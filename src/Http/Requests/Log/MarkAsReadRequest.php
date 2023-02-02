<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Log;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsReadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'Ilog' => ['required', 'integer'],
            'userId' => ['nullable', 'integer'],
            'readAt' => ['nullable', 'date'],
            'userActivityLog' => ['required', 'boolean'],
        ];
    }
}
