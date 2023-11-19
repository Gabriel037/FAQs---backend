<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqsController;

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

// CRUD faqs
Route::post('/create_faq', [FaqsController::class, 'store']);
Route::get('/faqs', [FaqsController::class, 'index']);
Route::get('/faq_by_id/{id}', [FaqsController::class, 'show']);
Route::put('/updated_faq/{id}', [FaqsController::class, 'updated']);
Route::delete('/delete_faq/{id}', [FaqsController::class, 'destroy']);
