<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use Carbon\Carbon;
use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Laravel\Database\Factories\DeviceFactory;
use dnj\UserLogger\Concerns\Loggable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                      $id
 * @property string                   $title
 * @property int                      $owner_id
 * @property User                     $user
 * @property array<string,mixed>|null $meta
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 */
class Device extends Model implements IDevice
{
    use HasFactory;
    use Loggable;

    public static function newFactory(): DeviceFactory
    {
        return DeviceFactory::new();
    }

    protected $table = 'error_tracker_devices';
    protected $fillable = [
        'title',
        'owner_id',
        'meta',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, array $filters)
    {
        if (array_key_exists('owner', $filters)) {
            if (null === $filters) {
                $builder->whereNull('owner_id');
            } else {
                if ($filters['owner'] instanceof Authenticatable) {
                    $filters['owner'] = $filters['owner']->getAuthIdentifier();
                }
                $builder->where('owner_id', $filters['owner']);
            }
        }
        if (isset($filters['title'])) {
            $builder->where('title', 'LIKE', '%'.$filters['title'].'%');
        }
        if (isset($filters['user'])) {
            // TODO
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function getOwnerUserId(): int
    {
        return $this->owner_id;
    }

    public function getOwnerUserColumn(): string
    {
        return 'owner_id';
    }
}
