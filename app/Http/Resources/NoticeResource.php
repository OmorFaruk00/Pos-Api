<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticeResource extends JsonResource
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
            'description' => $this->description,
            'files' => $this->image,   
            'published_date' => $this->created_at ? Carbon::parse($this->created_at)->format('d / M / y') : '',
            
        ];
    }
}