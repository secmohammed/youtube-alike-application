<?php
/**
 * Guest Area.
 */
Route::middleware('guest:api')
	->group(base_path('routes/api/guest.php'));
/**
 * Authenticated Area.
 */
Route::middleware('auth:api')
	->group(base_path('routes/api/auth.php'));
/**
 * Public Area is registered at RouteServiceProvider.
 */
