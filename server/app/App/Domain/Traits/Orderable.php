<?php

namespace App\App\Domain\Traits;

trait Orderable {
	public function scopeLatestFirst($query) {
		return $query->orderBy('created_at', 'desc');
	}
}