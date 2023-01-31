<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Database\Factories\LogFactory;
use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int              id
 * @property int              application_id
 * @property int              device_id
 * @property int|null         reader_user_id
 * @property \DateTime|null   read_at
 * @property mixed            level
 * @property string           message
 * @property string|null      date
 * @property \DateTime        created_at
 * @property \DateTime        updated_at
 */
class Log extends Model implements ILog
{
    use Filterable;
    use HasFactory;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getApplicationId(): int
    {
        return $this->application_id;
    }

    public function setApplicationId(int $application_id): void
    {
        $this->application_id = $application_id;
    }

    public function getDeviceId(): int
    {
        return $this->device_id;
    }

    public function setDeviceId(int $device_id): void
    {
        $this->device_id = $device_id;
    }

    public function getReaderUserId(): ?int
    {
        return $this->reader_user_id;
    }

    public function setReaderUserId(?int $reader_user_id): void
    {
        $this->reader_user_id = $reader_user_id;
    }

    public function getReadAt(): ?\DateTime
    {
        return $this->read_at;
    }

    public function setReadAt(?\DateTime $read_at): void
    {
        $this->read_at = $read_at;
    }

    /**
     * @return mixed
     */
    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function setLevel(mixed $level): void
    {
        $this->level = $level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getAppId(): int
    {
        return $this->getApplicationId();
    }

    /**
     * @return array|mixed[]|null
     */
    public function getData(): ?array
    {
        return $this->getData();
    }

    protected static function newFactory(): LogFactory
    {
        return LogFactory::new();
    }
}
