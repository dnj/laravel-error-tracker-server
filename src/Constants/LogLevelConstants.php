<?php

namespace dnj\ErrorTracker\Laravel\Server\Constants;

class LogLevelConstants
{
    // log statuses
    public const EMERGENCY = 'emergency';
    public const ALERT = 'alert';
    public const CRITICAL = 'critical';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const NOTICE = 'notice';
    public const INFO = 'info';
    public const DEBUG = 'debug';


    /**
     * @var array|string[]
     */
    public static array $statuses = [
        self::EMERGENCY,
        self::ALERT,
        self::CRITICAL,
        self::ERROR,
        self::WARNING,
        self::NOTICE,
        self::INFO,
        self::DEBUG,
    ];
}









