<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description'   => $this->description,
            'price'  => 'R$ ' . number_format($this->price/100,2,",","."),
            'created_at'  => $this->created_at->format('d/m/Y'),
            [
                'category_id' => $this->category_id,
                'category_name' => $this->category_name,
            ]
        ];
    }
}
