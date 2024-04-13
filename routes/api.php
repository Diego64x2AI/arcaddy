<?php

use App\Http\Controllers\Api\RankingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rankings/{cliente}', [RankingsController::class, 'rankings'])->name('api.rankings')->where('cliente', '[0-9]+');
Route::get('/rankings-quiz/{cliente}', [RankingsController::class, 'rankings_quiz'])->name('api.rankings.quiz')->where('cliente', '[0-9]+');
