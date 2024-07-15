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
      // $subcategoryResults = Subcategory::search($searched_word)->first();
      // // dd($subcategoryResults);
      // if($subcategoryResults!=null){

      //    $subcategoryResults = $subcategoryResults->organizations->pluck('branches')->flatten()->toArray();

      // }
      $searched_words = explode(',', $searched_word); // преобразуем строку в массив
      $subcategoryResults = Subcategory::where(function($query) use ( $searched_words) {
        foreach ($searched_words as $word) {
            $query->orWhere(function($query) use ($word) {
                $query->where('subCategory_am', 'like', '%' . $word . '%')
                      ->orWhere('subCategory_en', 'like', '%' . $word . '%')
                      ->orWhere('subCategory_ru', 'like', '%' . $word . '%');
            });
        }
    })->get();

// dd($subcategoryResults);
 $branch_ids_array = [];
 $subcategoryResults = $subcategoryResults->pluck('organizations')->flatten()->pluck('branches')->flatten()->pluck('id')->toArray();



      // $organizationResults = Organization::search($searched_word)->get();
      // dd($organizationResults);

      $searched_words = explode(',', $searched_word); // преобразуем строку в массив
      $organizationResults = Organization::where(function($query) use ( $searched_words) {
        foreach ( $searched_words as $word) {
            $query->orWhere(function($query) use ($word) {
                $query->where('name_am', 'like', '%' . $word . '%')
                      ->orWhere('name_en', 'like', '%' . $word . '%')
                      ->orWhere('name_ru', 'like', '%' . $word . '%');
            });
        }
    })->get();
// dd($organizationResults);
      // $organizationResults = $organizationResults->pluck('branches')->flatten()->toArray();
      // dd($organizationResults);
      $organizationResults = $organizationResults->pluck('branches')->flatten()->pluck('id')->toArray();
      // dd($organizationResult);

      // $branchResults = Branch::search($searched_word)->get()->toArray();
      $searched_words = explode(',', $searched_word); // преобразуем строку в массив
      $branchResults = Branch::where(function($query) use ( $searched_words) {
        foreach ( $searched_words as $word) {
            $query->orWhere(function($query) use ($word) {
                $query->where('address_am', 'like', '%' . $word . '%')
                      ->orWhere('address_ru', 'like', '%' . $word . '%')
                      ->orWhere('address_en', 'like', '%' . $word . '%')
                      ->orWhere('address_en', 'like', '%' . $word . '%')
                      ->orWhere('title_am', 'like', '%' . $word . '%')
                      ->orWhere('title_ru', 'like', '%' . $word . '%')
                      ->orWhere('title_en', 'like', '%' . $word . '%');
            });
        }
    })->get();
    // dd($branchResults);
    $branchResults = $branchResults->pluck('id')->toArray();

    // $subcategoryResults1 = collect($subcategoryResults);
    // dd($subcategoryResults1);
    // $organizationResults1 = collect($organizationResults);

    // $branchResults1 = collect($branchResults);
// dd($organizationResults1,$branchResults1);
// dd($subcategoryResults,$organizationResult,$branchResults);
      // $allResults = $branchResults1->merge($organizationResults1)->merge($subcategoryResults1);
      // dd($allResults);

      $allResults = array_merge($branchResults,$organizationResults,$subcategoryResults);
// dd($allResults);
      // $ids = $allResults->pluck('id');
      $data = Branch::whereIn('id', $allResults);

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
        ->havingRaw('distance >= ?', [$distance])
        ->orderBy('distance');
    }

      $data = $data->paginate(30)->withQueryString();
      // $branchResults
      // $uniqueMergedArray = $this->getUniqueMergedArray($subcategoryResults,$organizationResults);
      // dd($uniqueMergedArray);
      return $this->sendResponse(NewBranchResource::collection($data),'success',['page_count' => $data->lastPage()]);
      // return $this->sendResponse(NewBranchResource::collection($uniqueMergedArray),'success');

    }
    public function getUniqueMergedArray($array1, $array2) {
  // dd($array1, $array2);
      $mergedArray = array_merge($array1, $array2);  // Merge the arrays
      $serializedArray = array_map('serialize', $mergedArray);  // Serialize each sub-array
      $uniqueSerializedArray = array_unique($serializedArray);  // Get unique serialized sub-arrays
      return array_map('unserialize', $uniqueSerializedArray);  // Unserialize back to original array format
  }



}
