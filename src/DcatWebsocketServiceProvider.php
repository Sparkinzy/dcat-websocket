<?php

namespace Sparkinzy\DcatWebsocket;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class DcatWebsocketServiceProvider extends ServiceProvider
{
    protected $js
        = [
            'js/echo.iife.js',
            'js/pusher.min.js'
        ];
    protected $css
        = [
        ];

    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->configureConfig();
        # 前端资源加载与初始化
        Admin::requireAssets('@sparkinzy.dcat-websocket');
        $this->setupScript();

    }

    /**
     * 初始化配置
     */
    protected function configureConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/websockets.php',
            'websockets');
        config([
            'broadcasting.connections.pusher' => [
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
            ]
        ]);
        $excepts    = config('admin.auth.except');
        $excepts [] = 'broatcasting/auth';
        config([
            'admin.auth.except' => $excepts
        ]);
    }

    /**
     * 初始化Echo
     */
    protected function setupScript()
    {
        $key     = config('broadcasting.connections.pusher.key');
        $wsPort  = config('broadcasting.connections.pusher.options.port');
        $user_id = Admin::user() ?? 0;
        Admin::script(<<<JS
window.Echo = window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{$key}',
    wsHost:location.hostname,
    wsPort:{$wsPort},
    enabledTransports: ['ws','wss'],
    forceTLS: false
});
window.Echo.private("room.{$user_id}")
    .listen('.toast.success',(e)=>{
        Dcat.success(e.message);
    })
    .listen('.toast.error',(e)=>{
        Dcat.error(e.message);
    });
JS
        );
    }
}
