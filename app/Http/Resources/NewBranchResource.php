<?php

namespace App\Http\Resources;

use App\Traits\CheckOpendClosedTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewBranchResource extends JsonResource
{
  use CheckOpendClosedTrait;
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
            "latitude" =>floatval($this->latitude),
            "longitude"=>floatval($this->longitude),
            "title"=>$this->title()=="null" ? null : $this->title(),
            "work_time"=>$this->working_time()=="null" ? null : $this->working_time(),
            "opend_status"=>$this->working_time()=="null" ? null : $this->checkTime($this->work_time_en,$this->id),
            "organization"=> new OrganizationsBranchResource($this->organizations ?? null)
        ];
    }

}
