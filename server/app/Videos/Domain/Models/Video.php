<?php

namespace App\Videos\Domain\Models;

use App\Channels\Domain\Models\Channel;
use App\Users\Domain\Models\User;
use App\Videos\Domain\Models\View;
use App\Votes\Domain\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model {
	use SoftDeletes/*, Searchable*/;
	protected $fillable = [
		'channel_id',
		'uid',
		'title',
		'description',
		'processed',
		'video_id',
		'video_filename',
		'visibility',
		'allow_votes',
		'allow_comments',
		'processed_percentage',
	];
	protected $casts = [
		'allow_comments' => 'boolean',
		'allow_votes' => 'boolean',
	];
	public function channel() {
		return $this->belongsTo(Channel::class);
	}
	public function getRouteKeyName() {
		return 'uid';
	}
	public function views() {
		return $this->hasMany(View::class);
	}
	public function viewCount() {
		return $this->views->count();
	}
	public function scopeLatestFirst($query) {
		return $query->orderBy('created_at', 'desc');
	}
	public function isPrivate() {
		return $this->visibility === 'private';
	}
	public function selfOwned($user = null) {
		if (!$user && !auth()->check()) {
			return false;
		}
		if (!$user && auth()->check()) {
			$user = auth()->user();
		}
		return $this->channel->user_id == $user->id;
	}
	public function canBeAccessed($user = null) {
		if (!$user && auth()->check()) {
			$user = auth()->user();
		}
		if (!$user && $this->isPrivate()) {
			return false;
		}
		if ($user && $this->isPrivate() && !$this->selfOwned($user)) {
			return false;
		}
		return true;
	}
	public function votes() {
		return $this->morphMany(Vote::class, 'voteable');
	}
	public function upVotes() {
		return $this->votes()->VoteType();
	}
	public function downVotes() {
		return $this->votes()->VoteType(false);
	}
	public function voteFromUser($user) {
		return $this->votes()->where('user_id', $user->id);
	}
	public function votesAllowed() {
		return !!$this->votes_allowed;
	}

}
