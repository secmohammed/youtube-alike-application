<?php

namespace App\Channels\Domain\Models;

use App\Subscriptions\Domain\Models\Subscription;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use App\Videos\Domain\Models\View;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model {
	// use Searchable;
	protected $fillable = ['name', 'slug', 'description', 'avatar'];
	public function getRouteKeyName() {
		return 'slug';
	}
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function videos() {
		return $this->hasMany(Video::class);
	}
	public function subscriptions() {
		return $this->hasMany(Subscription::class);
	}
	public function subscriptionCount() {
		return $this->subscriptions->count();
	}
	public function totalVideoViews() {
		return $this->hasManyThrough(View::class, Video::class)->count();
	}
}
