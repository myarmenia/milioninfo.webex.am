<?php

namespace App\Http\Resources;

use App\Models\CategorySubcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrganizationsBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      $category_ids = DB::table('categories_subcategories')->where('subcategory_id',$this->subcategory_id)->pluck('category_id');

        return [
          'id' => $this->id,
          'name' => $this->translation(),
          'subcategory_id' => $this->subcategory_id,
          'subcategory' => $this->subcategories->translation(),
          'category_ids' => $category_ids,
          'weblinks' => new WeblinkResource($this->weblinks=="null" ? null : $this->weblinks),
          'images' => OrganizationImagesResource::collection($this->images ?? null),
        ];
    }
}
