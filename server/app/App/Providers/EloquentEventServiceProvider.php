<?php

namespace App\App\Providers;

use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		\App\Channels\Domain\Models\Channel::observe(\App\Channels\Domain\Observers\ChannelObserver::class);
		\App\Videos\Domain\Models\Video::observe(\App\Videos\Domain\Observers\VideoObserver::class);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
