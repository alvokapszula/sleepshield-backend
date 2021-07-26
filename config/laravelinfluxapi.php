<?php
return [

    'protocol' => env('INFLUX_PROTOCOL', 'http'),
    'host' => env('INFLUX_HOST', 'localhost'),
    'port' => env('INFLUX_PORT', '8086'),
    'database' => env('INFLUX_DATABASE', 'telegraf'),
    'serie' => env('INFLUX_SERIE', 'system'),
    'username' => env('INFLUX_USER', ''),
    'password' => env('INFLUX_PASSWORD', ''),
    'ssl' => env('INFLUX_SSL', false),
    'verify_ssl' => env('INFLUX_VERIFY_SSL', false),
    'timeout' => env('INFLUX_TIMEOUT', 0),
    'connectTimeout' => env('INFLUX_CONNECTTIMEOUT', 0)

];
