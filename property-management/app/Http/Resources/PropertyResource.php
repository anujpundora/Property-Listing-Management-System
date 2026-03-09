<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'price' => $this->price,
        'location' => $this->location,
        'type' => $this->type,
        'status' => $this->status,
        'owner' => [
            'id' => $this->user->id,
            'name' => $this->user->name
        ],
        'created_at' => $this->created_at->format('Y-m-d')
    ];
}
}
