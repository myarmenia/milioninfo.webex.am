<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchesOrganizationResource extends JsonResource
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
          'weblinks'=>$this->weblinks,
          'branches'=>BranchResource::collection($this->branches ?? null),
          'images'=>OrganizationImagesResource::collection($this->images ?? null),
        ];
    }
}
