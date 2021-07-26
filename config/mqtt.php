<?php
return [

    'host' => env('MQTT_HOST', 'localhost'),
    'port' => env('MQTT_PORT', '9001'),
    'user' => env('MQTT_USER', ''),
    'password' => env('MQTT_PASSWORD', ''),
    'clientid' => env('MQTT_CLIENTID', ''),
    'basetopic' => env('MQTT_BASETOPIC', '')

];
