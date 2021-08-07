<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'panel' => [
        'driver' => env('PANEL_DB_DRIVER', 'mysql'),
        'host' => env('PANEL_DB_HOST', 'localhost'),
        'database' => env('PANEL_DB_DATABASE', 'root'),
        'port' => env('PANEL_DB_PORT', 3306),
        'username' => env('PANEL_DB_USERNAME', 'root'),
        'password' => env('PANEL_DB_PASSWORD', ''),
        'charset' => env('PANEL_DB_CHARSET', 'utf8'),
        'collation' => env('PANEL_DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('PANEL_DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('PANEL_DB_MAX_IDLE_TIME', 60),
        ]
    ],
    'daemon' => [
        'driver' => env('DAEMON_DB_DRIVER', 'mysql'),
        'host' => env('DAEMON_DB_HOST', 'localhost'),
        'database' => env('DAEMON_DB_DATABASE', 'root'),
        'port' => env('DAEMON_DB_PORT', 3306),
        'username' => env('DAEMON_DB_USERNAME', 'root'),
        'password' => env('DAEMON_DB_PASSWORD', ''),
        'charset' => env('DAEMON_DB_CHARSET', 'utf8'),
        'collation' => env('DAEMON_DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DAEMON_DB_PREFIX', ''),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('DAEMON_DB_MAX_IDLE_TIME', 60),
        ]
    ],
];
