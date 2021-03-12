<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'impact' => $this->impact,
            'visibility' => $this->visibility,
            'user' => $this->user,
            'components' => ComponentResource::collection($this->components),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
