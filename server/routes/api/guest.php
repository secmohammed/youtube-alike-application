<?php
Route::post('/auth/register', App\Users\Actions\RegisterUserAction::class);
Route::post('/auth/login', App\Users\Actions\LoginUserAction::class);
Route::post('/auth/forgot-password', App\Users\Actions\ForgotUserPasswordAction::class)->name('forgot.password');
Route::post('/auth/reset-password', App\Users\Actions\ResetUserPasswordAction::class)->name('password.reset');
