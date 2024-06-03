<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationsBranchesResource;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;

class NearestBranchesController extends BaseController
{
    public function __invoke(Request $request){

      $category = Category::find($request->category_id);

      //  $data = $category->subcategories->pluck('organizations')->flatten()->paginate(10)->withQueryString();
       $subcategories_id = $category->subcategories->pluck('id');
       $data = Organization::whereIn('subcategory_id',$subcategories_id)->paginate(10)->withQueryString();



      // return OrganizationsBranchesResource::collection($data);
      return $this->sendResponse(OrganizationsBranchesResource::collection($data),['page_count' => $data->lastPage()],'success');

    }
}
