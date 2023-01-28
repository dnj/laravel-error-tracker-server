<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Models;

use dnj\ErrorTracker\Laravel\Server\Tests\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;

class User extends BaseUser
{
    use HasFactory;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected $table = 'users';
}
