<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesOrganizationRequest;
use App\Http\Resources\BranchWithOrganizationResource;
use App\Http\Resources\CategorySubcategoryResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationsBranchesResource;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorySubcategoryController extends BaseController
{


    public function __invoke(CategoriesOrganizationRequest $request)
    {

      $latitude = $request->latitude;
      $longitude = $request->longitude;
      $coordinate =countCordinate($latitude,$longitude);

      // $category = Category::find($request->category_id);
      // $data = $category->subcategories->pluck('organizations')->flatten();


      $category = Category::find($request->category_id);

      $subcategories_id = $category->subcategories->pluck('id')->toArray();

      $organization_ids = Organization::whereIn('subcategory_id',$subcategories_id)->pluck('id');

      // $data = Branch::whereIn('organization_id',$organization_ids);
      // if($latitude!=null && $longitude!=null){

      //   $data = $data->where('latitude', '<=', $coordinate['latitude'])
      //   ->where('longitude', '<=', $coordinate['longitude']);
      // }

      //   $data = $data->paginate(30)->withQueryString();


      //   return $this->sendResponse(BranchWithOrganizationResource::collection($data),'success', ['page_count' => $data->lastPage()]);
      // $radius = $request->input('radius', 1); // Радиус поиска по умолчанию (10 км)
      $distance = 1.0; // 1.0 kilometer, which equals 1000 meters
      $data = Branch::whereIn('organization_id', $organization_ids);

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
      return $this->sendResponse(BranchWithOrganizationResource::collection($data),'success', ['page_count' => $data->lastPage()]);


    }
}
