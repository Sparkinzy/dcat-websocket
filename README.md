# Dcat Admin Extension

## 安装



修改broadcasting.php

```php 

return [
    'default'     => env('BROADCAST_DRIVER', 'pusher'),
    'connections' => [
        'pusher' => [
            'driver'  => 'pusher',
            'key'     => env('PUSHER_APP_KEY'),
            'secret'  => env('PUSHER_APP_SECRET'),
            'app_id'  => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS'  => false,
                'host'    => '127.0.0.1',
                'port'    => env('LARAVEL_WEBSOCKETS_PORT', 2080),
            ],
        ],
        ...
]
```


