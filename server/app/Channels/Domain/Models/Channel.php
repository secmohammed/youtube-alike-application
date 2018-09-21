<?php

namespace App\Channels\Domain\Models;

use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\Video;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model {
	protected $fillable = ['name', 'slug', 'description', 'avatar', 'user_id'];
	public function getRouteKeyName() {
		return 'slug';
	}
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function videos() {
		return $this->hasMany(Video::class);
	}
}
