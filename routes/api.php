<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FormationController;
use App\Http\Controllers\Api\UtilisateurFormationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::get('listeFormations',[FormationController::class,'index']);
//ADMIN
Route::middleware(['auth:api','admin'])->group(function(){
    Route::post('formation/create',[FormationController::class,'store']);
    Route::post('formation/update/{id}',[FormationController::class,'update']);
    Route::delete('formation/{id}',[FormationController::class,'destroy']);
});

//CANDIDAT
Route::middleware(['auth:api','candidat'])->group(function(){
    Route::post('candidater/create',[UtilisateurFormationController::class,'store']);
});