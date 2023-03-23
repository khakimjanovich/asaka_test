<?php

use App\Http\Controllers\DocumentController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::patch('/documents/{document_id}', [DocumentController::class, 'update']);
    Route::post('/documents/{document_id}/publish', [DocumentController::class, 'publish']);
    Route::get('documents', [DocumentController::class, 'index']);
});
