<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Todo extends JsonResource
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
            'id'=>$this->id,
            'state'=>$this->state,
            'user_id'=>$this->user_id,
            'title'=>$this->title,
            'body'=>$this->body
       
        ];
    }
    public function with($request)
    {
        return[
            'version'=>'1.0.0',
        
        ];
    }
}
