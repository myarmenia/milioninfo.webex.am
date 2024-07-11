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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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



      // $distance = 1.0;
      $distance = 0;
      // $data = Branch::search($searched_word,$latitude, $longitude);
      // $data = Branch::search($searched_word);
      $subcategoryResults = Subcategory::search($searched_word)->first();
      // dd($subcategoryResults);
      if($subcategoryResults!=null){

         $subcategoryResults = $subcategoryResults->organizations->pluck('branches')->flatten()->toArray();

      }

// dd($subcategoryResults);
      $organizationResults = Organization::search($searched_word)->get();
dd($organizationResults);
      $organizationResults = $organizationResults->pluck('branches')->flatten()->toArray();
      // dd($organizationResults);

      $branchResults = Branch::search($searched_word)->get()->toArray();

      // dd($branchResults);

      // $allResults = $branchResults->merge($organizationResults)->merge($subcategoryResults);
      // $allResults = array_merge($branchResults,$organizationResults,$subcategoryResults);

      // $ids = $allResults->pluck('id');
      // $data = Branch::whereIn('id', $ids);

// dd($data);
    //   if ($latitude !== null && $longitude !== null) {

    //     $data = $data->select(
    //         'branches.*',
    //         DB::raw("6371 * acos(cos(radians($latitude))
    //         * cos(radians(latitude))
    //         * cos(radians(longitude) - radians($longitude ))
    //         + sin(radians($latitude))
    //         * sin(radians(latitude))) AS distance")
    //     )
    //     ->havingRaw('distance >= ?', [$distance])
    //     ->orderBy('distance');
    // }

      // $data=$data->paginate(30)->withQueryString();

      $uniqueMergedArray = $this->getUniqueMergedArray($subcategoryResults,$organizationResults, $branchResults);
      // dd($uniqueMergedArray);
      // return $this->sendResponse(NewBranchResource::collection($data),'success',['page_count' => $data->lastPage()]);
      return $this->sendResponse(NewBranchResource::collection($uniqueMergedArray),'success');

    }
    public function getUniqueMergedArray($array1, $array2,  $array3) {
  dd($array1, $array2,  $array3);
      $mergedArray = array_merge($array1, $array2, $array3);  // Merge the arrays
      $serializedArray = array_map('serialize', $mergedArray);  // Serialize each sub-array
      $uniqueSerializedArray = array_unique($serializedArray);  // Get unique serialized sub-arrays
      return array_map('unserialize', $uniqueSerializedArray);  // Unserialize back to original array format
  }



}
