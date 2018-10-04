<?php

namespace App\Users\Domain\Models;

use App\App\Domain\Traits\CanResetPasswordTrait as CanResetPassword;
use App\Channels\Domain\Models\Channel;
use App\Subscriptions\Domain\Models\Subscription;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements CanResetPasswordContract, JWTSubject {
	use Notifiable, CanResetPassword;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	public function avatar($size = 45) {
		return 'http://www.gravatar.com/avatar/' . md5($this->email) . '?s=' . $size . '&d=mm';
	}
	public function channels() {
		return $this->hasMany(Channel::class, 'user_id');
	}
	public function videos() {
		return $this->hasManyThrough(\App\Videos\Domain\Models\Video::class, \App\Channels\Domain\Models\Channel::class);
	}
	public function subscriptions() {
		return $this->hasMany(Subscription::class);
	}
	public function subscribedChannels() {
		return $this->belongsToMany(Channel::class, 'subscriptions');
	}
	public function isSubscribedTo(Channel $channel) {
		return $this->subscriptions()->where('channel_id', $channel->id)->exists();
	}
	public function ownsChannel(Channel $channel) {
		return $this->id == $channel->user_id;
	}
	public function getJWTIdentifier() {
		return $this->getKey();
	}
	public function getJWTCustomClaims() {
		return [];
	}
}
