<?php

namespace Sparkinzy\DcatWebsocket;

use Dcat\Admin\Admin;
use Dcat\Admin\Extend\ServiceProvider;

class DcatWebsocketServiceProvider extends ServiceProvider
{
    protected $js
        = [
            'js/dcat-websocket.js',
        ];
    protected $css
        = [
        ];

    public function register()
    {
    }

    public function init()
    {
        parent::init();

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        // 前端资源加载与初始化
        Admin::requireAssets('@sparkinzy.dcat-websocket');
    }
}
