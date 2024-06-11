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

      // $data = Organization::whereIn('subcategory_id',$subcategories_id)->paginate(30)->withQueryString();
      $organization_ids = Organization::whereIn('subcategory_id',$subcategories_id)->pluck('id');

      $data=Branch::whereIn('organization_id',$organization_ids);
      if($latitude!=null && $longitude!=null){

        $data=$data->where('latitude', '<=', $coordinate['latitude'])
        ->where('longitude', '<=', $coordinate['longitude']);
      }

     $data=$data->paginate(30)->withQueryString();
// dd($data);
        // return $this->sendResponse(OrganizationsBranchesResource::collection($data),'success',['page_count' => $data->lastPage()]);
        return $this->sendResponse(BranchWithOrganizationResource::collection($data),'success', ['page_count' => $data->lastPage()]);
    }
}
