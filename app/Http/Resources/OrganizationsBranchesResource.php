<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationsBranchesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $latitude = $request->latitude;
      $longitude = $request->longitude;
      $branches = $this->branches;
      
    // dd($latitude,$longitude);
    if($latitude!=null && $longitude!=null){

      $coordinate =countCordinate($latitude,$longitude);

      $branches= $branches->where('latitude', '<=', $coordinate['latitude'])
      ->where('longitude', '<=', $coordinate['longitude']);
    }

       return [
          'id'=>$this->id,
          'name'=>$this->translation(),
          'subcategory'=>$this->subcategories->translation(),
          'weblinks'=>new WeblinkResource($this->weblinks),
          'branches'=>NearestBranchResource::collection($branches ),
          'images'=>OrganizationImagesResource::collection($this->images ?? null),

      ];
    }

}
