<?php

namespace dnj\ErrorTracker\Laravel\Server\Models;

use Carbon\Carbon;
use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Database\Factories\LogFactory;
use dnj\UserLogger\Concerns\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                      $id
 * @property Carbon                   $created_at
 * @property int                      $app_id
 * @property int                      $device_id
 * @property int|null                 $reader_id
 * @property User|null                $reader
 * @property Carbon|null              $read_at
 * @property LogLevel                 $level
 * @property string                   $message
 * @property array<string,mixed>|null $data
 */
class Log extends Model implements ILog
{
    use HasFactory;
    use Loggable;

    public const UPDATED_AT = null;

    public static function newFactory(): LogFactory
    {
        return LogFactory::new();
    }

    protected $table = 'error_tracker_logs';
    protected $fillable = [
        'created_at',
        'app_id',
        'device_id',
        'reader_id',
        'read_at',
        'level',
        'message',
        'data',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'level' => LogLevel::class,
        'data' => 'array',
    ];

    public function reader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, array $filters)
    {
        if (isset($filters['apps'])) {
            $filters['apps'] = array_map(fn ($v) => $v instanceof IApp ? $v->getId() : $v, $filters['apps']);
            $builder->whereIn('app_id', $filters['apps']);
        }
        if (isset($filters['devices'])) {
            $filters['devices'] = array_map(fn ($v) => $v instanceof IDevice ? $v->getId() : $v, $filters['devices']);
            $builder->whereIn('device_id', $filters['devices']);
        }
        if (isset($filters['levels'])) {
            $filters['levels'] = array_map(fn ($v) => $v->name, $filters['levels']);
            $builder->whereIn('level', $filters['levels']);
        }
        if (isset($filters['message'])) {
            $builder->where('message', 'LIKE', '%'.$filters['message'].'%');
        }
        if (isset($filters['unread'])) {
            if ($filters['unread']) {
                $builder->whereNull('read_at');
            } else {
                $builder->whereNotNull('read_at');
            }
        }

        if (isset($filters['user'])) {
            // TODO
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getAppId(): int
    {
        return $this->app_id;
    }

    public function getDeviceId(): int
    {
        return $this->device_id;
    }

    public function getReaderUserId(): ?int
    {
        return $this->reader_id;
    }

    public function getReadAt(): ?Carbon
    {
        return $this->read_at;
    }

    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
