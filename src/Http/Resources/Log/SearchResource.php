<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Resources\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
