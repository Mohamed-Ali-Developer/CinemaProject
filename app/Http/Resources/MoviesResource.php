<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoviesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Movie_id' => $this->id,
            'name' => $this->title,
            'poster' => $this->poster,
            'duration' => $this->duration,
            'language' => $this->language,
            'status'=>$this->status,
            'description'=>$this->description,
            'Genres' => $this->genres->pluck('name')->values()
        ];
    }
}
