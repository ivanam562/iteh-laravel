<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
    public static $wrap = 'provider'; 

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'phone_number' => $this->resource->phone_number,
            'years_of_experience' => $this->resource->years_of_experience,
            'email' => $this->resource->email,
        ];
    }
}
