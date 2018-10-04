<?php

namespace App\App\Providers;

use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Channels\Domain\Models\Channel' => 'App\Channels\Domain\Policies\ChannelPolicy',
		'App\Videos\Domain\Models\Video' => 'App\Videos\Domain\Policies\VideoPolicy',
		'App\Comments\Domain\Models\Comment' => 'App\Comments\Domain\Policies\CommentPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
		Gate::define('update-channel', 'App\Channels\Domain\Policies\ChannelPolicy@update');
		Gate::define('subscribe-this-channel', 'App\Channels\Domain\Policies\ChannelPolicy@subscribe');
		Gate::define('unsubscribe-this-channel', 'App\Channels\Domain\Policies\ChannelPolicy@unsubscribe');
		Gate::define('update-video', 'App\Videos\Domain\Policies\VideoPolicy@update');
		Gate::define('delete-video', 'App\Videos\Domain\Policies\VideoPolicy@destroy');
		Gate::define('access-video', 'App\Videos\Domain\Policies\VideoPolicy@access');
		Gate::define('delete-comment', 'App\Comments\Domain\Policies\CommentPolicy@delete');
		//
	}
}
