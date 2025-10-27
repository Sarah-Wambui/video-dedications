<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DedicationController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\LandingController;
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


// Dedication flow
Route::get('/', function(){ return redirect('/dedicate'); });
Route::get('/dedicate', [DedicationController::class, 'landing'])->name('dedicate.landing');
Route::get('/dedicate/details', [DedicationController::class, 'create'])->name('dedicate.details');
Route::post('/dedicate/details', [DedicationController::class, 'store'])->name('dedicate.store');
Route::get('/dedicate/payment/{dedication:uuid}', [DedicationController::class, 'payment'])->name('dedicate.payment');
Route::get('/dedicate/success', [DedicationController::class, 'success'])->name('dedicate.success');

// Stripe webhook (no CSRF)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('webhook.stripe');

