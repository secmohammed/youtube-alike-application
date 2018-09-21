<?php

namespace App\Videos\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model {
	protected $fillable = [
		'ip', 'user_id',
	];
}