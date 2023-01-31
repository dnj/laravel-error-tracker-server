<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Resources\App;

use Illuminate\Http\Resources\Json\JsonResource;

class UpdateResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
