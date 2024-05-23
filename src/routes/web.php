<?php
use Illuminate\Support\Facades\Route;
use Aguva\Ussd\Controllers\TestController;

Route::get('simulator', [TestController::class, 'showSimulator'])->name('test.show-simulator');
Route::post('process-payload', [TestController::class, 'processPayload'])->name('test.process-payload');