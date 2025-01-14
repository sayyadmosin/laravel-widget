<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::options('widget/{any}', function(Request $request) {
    $origin = $request->header('Origin');
    $allowedOrigins = [
        'http://localhost',
        'http://localhost:8080',
        'http://127.0.0.1',
        'http://127.0.0.1:8080'
    ];
    
    $headers = [];
    if (in_array($origin, $allowedOrigins)) {
        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS,*',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400'
        ];
    }
    
    return response()->json([], 200, $headers);
})->where('any', '.*');

Route::prefix('widget')->group(function () {
    Route::get('render', [WidgetController::class, 'render']);
    Route::get('script.js', [WidgetController::class, 'script']);
    Route::get('styles.css', [WidgetController::class, 'styles']);
    Route::get('data', [WidgetController::class, 'data']);
    Route::post('action', [WidgetController::class, 'action']);
});
