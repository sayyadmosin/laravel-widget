<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetController;

Route::resource('widgets', WidgetController::class);