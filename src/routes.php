<?php

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Sparkinzy\DcatWebsocket\Http\Controllers;

Route::get(
    '/broadcasting/auth',
    Controllers\DcatWebsocketController::class.'@authenticate'
)
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->middleware(config('admin.route.middleware'))
    ->name('broadcasting.auth');

Route::post(
    '/broadcasting/auth',
    Controllers\DcatWebsocketController::class.'@authenticate'
)
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->middleware(config('admin.route.middleware'))
    ->name('broadcasting.auth.post');

Route::get('/push', function (\Illuminate\Http\Request $request) {
    return response([
        'code'    => 0,
        'message' => '测试信息:'.$request->get('msg'),
    ]);
})->name('push');
