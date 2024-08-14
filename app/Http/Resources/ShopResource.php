<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Brand' => $this -> brand,
            'Category' => $this ->category,
            'Most Sold Items' => $this ->most_sold_items,
            'City' => $this -> city,
            'District' => $this -> district,
            'Location Type' => $this ->location_type,
            'Capacity' => $this -> customer_capacity,
            'Number of Staff' => $this ->number_of_staff,
            'ID' => $this -> id
        ];
    }
}
