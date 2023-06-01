<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/get-options', function (Request $request) {
    try {
        $options = Option::whereIn('name', $request->names)->get()->pluck('content', 'name');
        return response()->json($options);
    } catch (\Throwable $th) {
        return response()->json([
            'error' => $th->getMessage()
        ]);
    }
});
