<?php
Route::get('/user', App\Users\Actions\AuthorizedUserAction::class);
Route::post('/auth/logout', App\Users\Actions\LogoutUserAction::class);
Route::put('/channel/{channel}', App\Channels\Actions\UpdateChannelAction::class);
Route::delete('/videos/{video}', App\Videos\Actions\DeleteVideoAction::class);
Route::post('/videos/{channel}', App\Videos\Actions\CreateVideoAction::class);
/**
 * Laravel has a problem with axios.put method, as it only recognizes get,post methods only.
 * dd(request()->all()) // returns null.
 */
Route::post('/videos/{video}/update', App\Videos\Actions\UpdateVideoAction::class);
Route::post('/videos/{video}/views', App\Videos\Actions\StoreVideoViewAction::class);