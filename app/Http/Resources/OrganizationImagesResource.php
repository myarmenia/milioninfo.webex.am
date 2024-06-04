<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationImagesResource extends JsonResource
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
          "image_path" =>route('get-file',['path'=>$this->image_path])
        ];
    }
}
