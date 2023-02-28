<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use Carbon\Carbon;
use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Laravel\Database\Factories\AppFactory;
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
 * @property User                     $owner
 * @property array<string,mixed>|null $meta
 * @property Carbon                   $created_at
 * @property Carbon                   $updated_at
 */
class App extends Model implements IApp
{
    use HasFactory;
    use Loggable;

    public static function newFactory(): AppFactory
    {
        return AppFactory::new();
    }

    protected $table = 'error_tracker_apps';
    protected $fillable = [
        'title',
        'owner_id',
        'meta',
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
        if (isset($filters['owner'])) {
            if ($filters['owner'] instanceof Authenticatable) {
                $filters['owner'] = $filters['owner']->getAuthIdentifier();
            }
            $builder->where('owner_id', $filters['owner']);
        }
        if (isset($filters['title'])) {
            $builder->where('title', 'LIKE', '%' . $filters['title'] . '%');
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
