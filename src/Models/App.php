<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\IApp;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        id
 * @property string     title
 * @property array|null extra
 * @property int|null   owner
 * @property string     owner_id_column
 * @property \DateTime  created_at
 * @property \DateTime  updated_at
 */
class App extends Model implements IApp
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @param array|null $extra
     */
    public function setExtra(?array $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * @return int|null
     */
    public function getOwner(): ?int
    {
        return $this->owner;
    }

    /**
     * @param int|null $owner
     */
    public function setOwner(?int $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getOwnerIdColumn(): string
    {
        return $this->owner_id_column;
    }

    /**
     * @param string $OwnerIdColumn
     */
    public function setOwnerIdColumn(string $OwnerIdColumn): void
    {
        $this->owner_id_column = $OwnerIdColumn;
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

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->getOwnerIdColumn();
    }
}
