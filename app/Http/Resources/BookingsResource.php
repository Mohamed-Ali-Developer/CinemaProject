<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BookingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'movie' => $this->showTime->movie->title,
            'cinema' => $this->showTime->hall->cinema->name,
            'hall' => $this->showTime->hall->name,
            'showtime' => [
                'start_at' => $this->showTime->start_at,
                'end_at' => $this->showTime->end_at,
            ],
            'seats' => $this->seats->map(function ($seat) {
                return [
                    'number' => $seat->number,
                    'row' => $seat->row,
                    'type' => $seat->type,
                    'price' => $seat->pivot->price,
                ];
            })->values(),
            'total' => $this->total_price,
            'status' => $this->status,
            'booked_at' => $this->booked_at,
        ];

    }
}
