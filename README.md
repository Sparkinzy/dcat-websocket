# Dcat Admin Extension

## 1.安装依赖包



```bash
# 依赖以下扩展包
composer require pusher/pusher-php-server "~4.0"
composer require beyondcode/laravel-websockets
# 发布相关文件 如 config/websockets.php
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"
```

## 2.添加配置 .env

```.dotenv
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=sparkinzy
PUSHER_APP_KEY=sparkinzy
PUSHER_APP_SECRET=sparkinzy
LARAVEL_WEBSOCKETS_PORT=2022
```


## 3.修改配置

首先要把 config/app.php 中的 App\Providers\BroadcastServiceProvider::class 注释打开

且 注释 App\Providers\BroadcastServiceProvider::class 中的 Broadcast::routes();

```PHP
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
```


## 4.添加私有渠道授权(公共渠道可忽略此步骤)
在 routes/channels.php 中加入我们最开始，在前端 JS 中写的监听频道：

```php

Broadcast::channel('room', function () {
    return true;
});
```


### 5.广播配置

在 config/broadcasting.php 中的 connections.pusher 下加入两个配置信息：
```php
'connections' => [
    'pusher' => [
        'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
                // 拦截 pusher 的广播后，转发到目标 ip
                'host' => '127.0.0.1',
                // 转发的端口，就是我们之前在 .env 文件中配置的 2022 端口
                'port' => env('LARAVEL_WEBSOCKETS_PORT', 2022),
            ],
    ];
];
```

## 6.启动socket监听
```bash
php artisan websockets:serve --port=2022
```

## Admin/bootstrap.php 启用
```php
$user_id = Admin::user()->id ?? 0;
Admin::script(<<<JS
// 公共渠道
DcatEcho.channel('task')
.listen('TaskSuccessEvent',function(e){
    console.log(e)
    $('#task-'+e.task_id).html('发布成功');
});
// 私有渠道
DcatEcho.private('room.{$user_id}')
  .listen('TaskErrorEvent',(e)=>{
      console.log(e)
  })

JS
);

```



## 前端向后端发送消息

```js
// 这里新增一个向服务端发送消息的方法
// 第一个参数是事件名，这个可以随意写，不需要与 Laravel 中做对应
// 第二个参数是具体数据，这个就更随意了
DcatEcho.connector.pusher.send_event('hi_girl', {
    my_name: 'LiamHao',
    my_height: 180,
});
```
