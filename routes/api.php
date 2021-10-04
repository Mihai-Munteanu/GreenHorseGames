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

Route::post('/competitions', [CompetitionController::class, 'store']);

Route::post('/competitions/{competition}/players', [CompetitionPlayerController::class, 'store']);

Route::put('/competitions/{competition}/players/{player}/increment', [CompetitionPlayerController::class, 'increment']);

Route::get('/competitions/{competition}', [CompetitionController::class, 'show']);
