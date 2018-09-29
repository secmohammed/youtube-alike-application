<?php

namespace App\Votes\Domain\Models;

use App\Users\Domain\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'videos' => App\Videos\Domain\Models\Video::class,
]);
class Vote extends Model {
	protected $fillable = ['type', 'user_id'];
	protected $casts = ['type' => 'boolean'];
	public function voteable() {
		return $this->morphTo();
	}
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function scopeVoteType($query, $type = true) {
		return $query->whereType($type);
	}
	public function scopeRecentForUser($query, User $user) {
		return $query->recent()->where('user_id', $user->id);
	}
	public function scopeRecent($query, $column = 'created_at') {
		return $query->orderBy($column, 'desc');
	}
	public function scopeByUser($query) {
		return $query->where('user_id', auth()->id());
	}

}
