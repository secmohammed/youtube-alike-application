<?php

namespace App\Videos\Domain\Models;

use App\Users\Domain\Models\User;
use Illuminate\Database\Eloquent\Model;

class View extends Model {
	protected $fillable = [
		'ip', 'user_id',
	];
	public function scopeByUser($query, User $user) {
		return $query->where('user_id', $user->id);
	}
	public function scopeByIp($query, $ip) {
		return $query->where('ip', $ip);
	}
	public function scopeLatestByUser($query, User $user) {
		return $query->byUser($user)->orderBy('created_at', 'desc')->take(1);
	}
	public function scopeLatestByIp($query, $ip) {
		return $query->byIp($ip)->orderBy('created_at', 'desc')->take(1);
	}
}