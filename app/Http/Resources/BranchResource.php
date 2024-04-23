<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          "address"=>$this->address(),
          "telephone"=>$this->telephone,
          "latitude" =>$this->latitude,
          "longitude"=>$this->longitude,
          "title"=>$this->title(),
      ];
    }
}
