<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Resources\Device;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
