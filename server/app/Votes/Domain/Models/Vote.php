<?php

namespace App\Votes\Domain\Models;

use App\Users\Domain\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
	protected $fillable = ['type', 'user_id'];
	public function voteable() {
		return $this->morphTo();
	}
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function scopeVoteType($query, $type = true) {
		return $query->whereType($type);
	}
}
