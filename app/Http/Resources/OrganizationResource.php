<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
        'id'=>$this->id,
        'name'=>$this->translation(),
        'subcategory'=>$this->subcategories->translation(),
        'weblinks'=>new WeblinkResource($this->weblinks),
        'branches'=>BranchResource::collection($this->branches ?? null),
        'images'=>OrganizationImagesResource::collection($this->images ?? null),
    ];
   
    }
}
