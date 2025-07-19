<?php

use App\Http\Controllers\CampayController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    $level = request()->query('level');
    session(['level' => $level]);

    return redirect('/guest/login');
});

Route::get('webhook', [CampayController::class, 'momoWebhook']);

Route::get('/test-connection', function () {
    return response()->json(['status' => 'Server is running', 'time' => now()]);
});
