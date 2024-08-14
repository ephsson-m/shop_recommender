<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */ 
    public function toArray(Request $request): array
    {
        return [
            'Name' => $this -> name,  
            'General Category' => $this -> general_category,
            'Sub Category' => $this -> sub_category,
            'Price' => $this -> price,
            'ID' => $this -> id
        ];
    }
}
