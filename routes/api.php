<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\CompetitionPlayerController;
use App\Http\Controllers\CompetitionPlayerIncrementController;

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

Route::post('/competitions', [CompetitionController::class, 'store']);

Route::post('/competitions/{competition}/players', [CompetitionPlayerController::class, 'store']);

Route::post('/competitions/{competition}/players/{player}', [CompetitionPlayerIncrementController::class, 'store']);

Route::get('/competitions/{competition}/players', [CompetitionPlayerIncrementController::class, 'index']);

//


// Route::post('/competitions', function (Request $request) {
//     return $request->input();
// });

//postman sau insomnia

