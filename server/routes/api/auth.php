<?php
/**
 * User Area
 */
Route::get('/user', App\Users\Actions\AuthorizedUserAction::class);
Route::post('/auth/logout', App\Users\Actions\LogoutUserAction::class);
/**
 * Channel Area
 */
Route::post('/channel/{channel}/update', App\Channels\Actions\UpdateChannelAction::class);
Route::post('/channel', App\Channels\Actions\CreateChannelAction::class);
/**
 * Video Area
 */
Route::delete('/videos/{video}', App\Videos\Actions\DeleteVideoAction::class);
Route::post('/videos/{channel}', App\Videos\Actions\CreateVideoAction::class);
Route::post('/videos/{video}/update', App\Videos\Actions\UpdateVideoAction::class);
Route::post('/videos/{video}/votes', App\Votes\Actions\StoreVideoVoteAction::class);
Route::delete('/videos/{video}/votes', App\Votes\Actions\DeleteVideoVoteAction::class);
