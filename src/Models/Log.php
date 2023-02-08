<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use Carbon\Carbon;
use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Database\Factories\LogFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int app_id
 * @property int device_id
 * @property string|null read
 * @property LogLevel level
 * @property string message
 * @property string|null data
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Log extends Model implements ILog
{
    use HasFactory;

    public function getId(): int
    {
        return $this->id;
    }

    public function getRead(): string
    {
        return $this->read;
    }

    public function setRead(array|null $read): Log
    {
        $this->read = json_encode($read);

        return $this;
    }

    public function getDeviceId(): int
    {
        return $this->device_id;
    }

    public function setDeviceId(int $device_id): Log
    {
        $this->device_id = $device_id;

        return $this;
    }

    public function getReaderUserId(): ?int
    {
        return optional(json_decode($this->read))->userId;
    }

    public function getReadAt(): ?\DateTime
    {
        $readAt = optional(json_decode($this->read))->readAt;

        return $readAt ? Carbon::make($readAt) : $readAt;
    }

    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function setLevel(LogLevel $level): void
    {
        $this->level = $level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Log
    {
        $this->message = $message;

        return $this;
    }

    public function getData(): ?array
    {
        return json_decode($this->data);
    }

    public function setData(?array $data): Log
    {
        $this->data = json_encode($data);

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function getAppId(): int
    {
        return $this->app_id;
    }

    public function setAppId(int $app_id): Log
    {
        $this->app_id = $app_id;

        return $this;
    }

    protected static function newFactory(): LogFactory
    {
        return LogFactory::new();
    }
}
