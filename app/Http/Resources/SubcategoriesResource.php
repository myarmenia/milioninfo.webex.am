<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $lang=app()->getLocale();
      $subname = $lang=='am' ? 'subCategory_am' :
                 ($lang=='ru' ? 'subCategory_ru' :
                 'subCategory_en');

        return [
          'id'=>$this->id,
          'name'=>$this->$subname,
        ];
    }
}
