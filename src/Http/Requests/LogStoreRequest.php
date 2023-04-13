<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use dnj\ErrorTracker\Contracts\LogLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'app' => ['integer', 'required'],
            'device' => ['integer', 'required'],
            'level' => ['required', Rule::in(array_column(LogLevel::cases(), 'key'))],
            'message' => ['string', 'required'],
            'data' => ['array', 'nullable'],
        ];
    }
}
