<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationsBranchResource extends JsonResource
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
          'subcategory_id'=>$this->subcategory_id,
          'subcategory'=>$this->subcategories->translation(),
          'weblinks'=>new WeblinkResource($this->weblinks=="null" ? null : $this->weblinks),
          'images'=>OrganizationImagesResource::collection($this->images ?? null),
        ];
    }
}
