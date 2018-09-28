<?php
/**
 * Guest Area.
 */
Route::middleware('guest:api')
	->group(base_path('routes/api/guest.php'));
/**
 * Authenticated Area.
 */
Route::middleware(['jwt-authenticate', 'auth:api'])
	->group(base_path('routes/api/auth.php'));
/**
 * Public Area is registered at RouteServiceProvider.
 */
