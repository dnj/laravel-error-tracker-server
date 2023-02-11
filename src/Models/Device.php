<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Database\Factories\DeviceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         id
 * @property string|null title
 * @property array|null extra
 * @property int|null    owner_id
 * @property string      owner_id_column
 * @property \DateTime   created_at
 * @property \DateTime   updated_at
 */
class Device extends Model implements IDevice
{
    use HasFactory;

    protected $fillable = ['title'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

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

    public function setExtra(?array $extra): Device
    {
        $this->extra = json_encode($extra);

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->owner_id;
    }

    public function setOwnerId(?int $owner_id): Device
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    public function getOwnerIdColumn(): string
    {
        return $this->owner_id_column;
    }

    public function setOwnerIdColumn(string $owner_id_column): Device
    {
        $this->owner_id_column = $owner_id_column;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }


    protected static function newFactory(): DeviceFactory
    {
        return DeviceFactory::new();
    }

    public function scopeFilter(Builder $builder, array $attribute)
    {
        if (isset($attribute['owner'])) {
            $builder->where('owner_id', '=', $attribute['owner']);
        }
        if (isset($attribute['title'])) {
            $builder->where('title', 'LIKE', '%'.$attribute['title'].'%');
        }
        if (isset($attribute['user'])) {
            $builder->where('user', '=', $attribute['user']);
        }
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updated_at;
    }
}
