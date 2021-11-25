<?php

use App\Http\Middleware\VerifyCsrfToken;
use Sparkinzy\DcatWebsocket\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get( '/broadcasting/auth',
    Controllers\DcatWebsocketController::class.'@authenticate'
)
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->middleware(config('admin.route.middleware'))
    ->name('broadcasting.auth');

Route::post( '/broadcasting/auth',
    Controllers\DcatWebsocketController::class.'@authenticate'
)
    ->middleware(config('admin.route.middleware'))
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('broadcasting.auth.post');

Route::get('/push', function (\Illuminate\Http\Request $request) {
    return response([
        'code'=> 0,
        'message' => '测试信息:'.$request->get('msg')
    ]);
})->name('push');
