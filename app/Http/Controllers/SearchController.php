<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CategoriesOrganizationRequest;
use App\Http\Resources\NewBranchResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationsBranchesResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Branch;
use App\Models\Organization;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends BaseController
{
  public $model;
    /**
     * Handle the incoming request.
     */
    public function __invoke(CategoriesOrganizationRequest $request)
    {
      $searched_word = $request->query('searched_word');
      $latitude = $request->query('latitude');
      $longitude = $request->query('longitude');



      $distance = 1.0;
      // $data = Branch::search($searched_word,$latitude, $longitude);
      // $data = Branch::search($searched_word);
      $searchResults = Branch::search($searched_word)->get();

      $ids = $searchResults->pluck('id');
      $data = Branch::whereIn('id', $ids);

// dd($data);
      if ($latitude !== null && $longitude !== null) {

        $data = $data->select(
            'branches.*',
            DB::raw("6371 * acos(cos(radians($latitude))
            * cos(radians(latitude))
            * cos(radians(longitude) - radians($longitude ))
            + sin(radians($latitude))
            * sin(radians(latitude))) AS distance")
        )
        ->havingRaw('distance <= ?', [$distance])
        ->orderBy('distance');
    }

      $data=$data->paginate(30)->withQueryString();


      return $this->sendResponse(NewBranchResource::collection($data),'success',['page_count' => $data->lastPage()]);

    }

}
