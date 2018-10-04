<?php
Route::post('/webhook/encoding', App\Videos\Actions\EncodingWebhookAction::class);
Route::get('/search', App\App\Actions\IndexSearchAction::class);

/** Video area */
Route::get('/videos/{video}', App\Videos\Actions\ShowVideoAction::class);
Route::post('/videos/{video}/views', App\Videos\Actions\StoreVideoViewAction::class);
Route::get('/videos/{video}/votes', \App\Votes\Actions\ShowVideoVoteAction::class);
Route::get('/videos/{video}/comments', App\Comments\Actions\IndexCommentsAction::class);

/** channel area  */
Route::get('/channel/{channel}', App\Channels\Actions\ShowChannelAction::class);
Route::get('/channel/{channel}/videos', App\Channels\Actions\ShowChannelVideosAction::class);
Route::get('/channel', App\Channels\Actions\IndexChannelsAction::class);
/** user area */
Route::get('/user/{user}/channels', App\Channels\Actions\IndexUserChannelsAction::class);
Route::get('/user/{user}/videos', App\Videos\Actions\IndexUserVideosAction::class);
/**
 * Subscription Area.
 */
Route::get('/subscriptions/{channel}', App\Subscriptions\Actions\ShowSubscriptionAction::class);