<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'movie' => [
                'title' => $this->movie->title,
            ],
            'cinema' => [
                'name' => $this->hall->cinema->name,
            ],
            'hall' => [
                'name' => $this->hall->name,
                'id' => $this->hall->id,
            ],
            'id'=>$this->id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
        ];
    }
}
