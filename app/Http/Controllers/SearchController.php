<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Organization;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      $searched_word = $request->query('searched_word');
      $latitude = $request->query('latitude');
      $longitude = $request->query('longitude');
      $address = $request->query('address');
      $data = Organization::search($searched_word,$latitude, $longitude,$address);
      // $data = Subcategory::search($searched_word);


      return $this->sendResponse(OrganizationResource::collection($data->with('subcategories')->get()),'success');
      // return SubcategoryResource::collection($data->with('organizations')->get());

    }
}
