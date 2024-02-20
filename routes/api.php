<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MagicGatherController;
use App\Http\Controllers\API\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [AuthController::class, 'register']);

// User Login
Route::post('/login', [AuthController::class, 'login']);

Route::get('/cards', [MagicGatherController::class, 'getAllCards']);

Route::post('/deck/add-card', [MagicGatherController::class, 'addCardToDeck']);
Route::get('/deck/average-mana-cost', [MagicGatherController::class, 'calculateAverageManaCost']);
Route::get('/cards/search', [MagicGatherController::class, 'searchCards']);


Route::get('/formats', [MagicGatherController::class, 'getFormats']);
Route::get('/sets', [MagicGatherController::class, 'getSets']);
Route::get('/types', [MagicGatherController::class, 'getTypes']);
Route::get('/supertypes', [MagicGatherController::class, 'getSupertypes']);