<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\IDevice;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         id
 * @property string|null title
 * @property array|null extra
 * @property int         owner_id
 * @property string      owner_id_column
 * @property \DateTime   created_at
 * @property \DateTime   updated_at
 */
class Device extends Model implements IDevice
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return void
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array|array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @param string|null $extra
     */
    public function setExtra(?string $extra): void
    {
        $this->extra = $extra;
    }

    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     * @return void
     */
    public function setOwnerId(int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return string
     */
    public function getOwnerIdColumn(): string
    {
        return $this->owner_id_column;
    }

    /**
     * @param string $owner_id_column
     * @return void
     */
    public function setOwnerIdColumn(string $owner_id_column): void
    {
        $this->owner_id_column = $owner_id_column;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }
}
