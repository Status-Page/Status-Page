<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentGroupResource extends JsonResource
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
            'name' => $this->name,
            'visibility' => $this->visibility,
            'user' => $this->user,
            'order' => $this->order,
            'collapse' => $this->collapse,
            'components' => ComponentResource::collection($this->components()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
