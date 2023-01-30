<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\LogLevel;
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
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return $this->application_id;
    }

    /**
     * @param int $application_id
     */
    public function setApplicationId(int $application_id): void
    {
        $this->application_id = $application_id;
    }

    /**
     * @return int
     */
    public function getDeviceId(): int
    {
        return $this->device_id;
    }

    /**
     * @param int $device_id
     */
    public function setDeviceId(int $device_id): void
    {
        $this->device_id = $device_id;
    }

    /**
     * @return int|null
     */
    public function getReaderUserId(): ?int
    {
        return $this->reader_user_id;
    }

    /**
     * @param int|null $reader_user_id
     */
    public function setReaderUserId(?int $reader_user_id): void
    {
        $this->reader_user_id = $reader_user_id;
    }

    /**
     * @return \DateTime|null
     */
    public function getReadAt(): ?\DateTime
    {
        return $this->read_at;
    }

    /**
     * @param \DateTime|null $read_at
     */
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

    /**
     * @param mixed $level
     */
    public function setLevel(mixed $level): void
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string|null $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return int
     */
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
}
