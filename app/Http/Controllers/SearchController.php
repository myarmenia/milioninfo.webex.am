<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\NewBranchResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Branch;
use App\Models\Organization;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
  public $model;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $searched_word = $request->query('searched_word');
      $latitude = $request->query('latitude');
      $longitude = $request->query('longitude');

      // $data = Organization::search($searched_word,$latitude, $longitude);
      // $data = Subcategory::search($searched_word);
      $data = Branch::search($searched_word,$latitude, $longitude);
// dd($data->get());
      return $this->sendResponse(NewBranchResource::collection($data->with('organizations')->get()),'success');
      // return $this->sendResponse(OrganizationResource::collection($data->with('subcategories')->get()),'success');

      // return SubcategoryResource::collection($data->with('organizations')->get());

    }

}
