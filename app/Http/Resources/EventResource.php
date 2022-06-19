<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'files' => $this->image,             
            'description' => $this->description,
            'published_date' => $this->created_at ? Carbon::parse($this->created_at)->format('d / M / y') : '',
            
        ];
    }
}