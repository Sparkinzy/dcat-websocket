<?php

namespace Sparkinzy\DcatWebsocket\Http\Controllers;

use Dcat\Admin\Admin;
use Illuminate\Broadcasting\BroadcastController as Controller;
use Illuminate\Http\Request;

class DcatWebsocketController extends Controller
{
    public function authenticate(Request $request)
    {
        # 将后台的用户验证变更为Dcat auth
        $request->setUserResolver(function () {
            return Admin::user();
        });
        return parent::authenticate($request);
    }
}
