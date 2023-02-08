<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Database\Factories\AppFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    protected $fillable = ['title'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getExtra(): ?array
    {
        return $this->extra;
    }

    public function setExtra(?array $extra): void
    {
        $this->extra = json_encode($extra);
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setOwner(?int $owner): void
    {
        $this->owner = $owner;
    }

    public function getOwnerIdColumn(): string
    {
        return $this->owner_id_column;
    }

    public function setOwnerIdColumn(string $OwnerIdColumn): void
    {
        $this->owner_id_column = $OwnerIdColumn;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    public function getOwnerId(): ?int
    {
        return $this->getOwnerIdColumn();
    }

    protected static function newFactory(): AppFactory
    {
        return AppFactory::new();
    }
}
