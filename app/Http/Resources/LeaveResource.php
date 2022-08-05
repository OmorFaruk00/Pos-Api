<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
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
            'kinds_of_leave'=> $this->kinds_of_leave,
            'causes_of_leave'=> $this->causes_of_leave,
            'start_date'=> $this->start_date,
            'end_date'=> $this->end_date,
            'no_of_days'=> $this->no_of_days,
            'need_parmission'=> $this->need_parmission,
            'in_charge'=> $this->in_charge,
            'accept_salary_difference'=> $this->accept_salary_difference,
            'applied_by'=> $this->applied_by,
            'approved_by'=> $this->approved_by,
            'status'=> $this->status,           
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('d / M / y') : '',
            
        ];
    }
}