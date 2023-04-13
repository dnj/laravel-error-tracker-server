<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests;

use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class LogSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'apps' => ['array', 'required', 'sometimes'],
            'apps.*' => [new Exists(App::class, 'id')],

            'devices' => ['array', 'nullable'],
            'devices.*' => [new Exists(Device::class, 'id')],

            'levels' => ['array', 'nullable'],
            'levels.*' => [Rule::in(array_column(LogLevel::cases(), 'key'))],

            'message' => ['string'],
            'unread' => ['bool'],
        ];
    }
}
