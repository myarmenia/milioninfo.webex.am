<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchWithOrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

         return [

          "id"=>$this->id,
          "organization_id"=>$this->organization_id,
          "address"=>$this->address(),
          "telephone"=>$this->telephone,
          "latitude" =>$this->latitude,
          "longitude"=>$this->longitude,
          "title"=>$this->title(),
          "organization"=> new OrganizationsBranchResource($this->organizations ?? null)
         ];
    }
}
