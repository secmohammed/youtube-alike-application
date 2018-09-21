<?php

namespace App\Videos\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexUserVideosResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
        ];
    }
}
