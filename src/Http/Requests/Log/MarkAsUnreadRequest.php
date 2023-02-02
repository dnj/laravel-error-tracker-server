<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Requests\Log;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsUnreadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'Ilog' => ['required', 'integer'],
            'userActivityLog' => ['required', 'boolean'],
        ];
    }
}

// ILog|int $log, bool $userActivityLog = false
