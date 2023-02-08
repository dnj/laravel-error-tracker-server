<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Log;

use dnj\ErrorTracker\Contracts\LogLevel;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'app' => ['integer', 'required'],
            'device' => ['integer', 'required'],
            'level' => ['required', 'in:'.implode(',', getEnumValues(LogLevel::cases()))],
            'message' => ['string', 'required'],
            'data' => ['array', 'nullable'],
            'data.readAt' => ['nullable', 'date'],
            'data.userId' => ['nullable', 'int'],
            'read' => ['array', 'nullable'],
        ];
    }
}
