<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationsBranchesResource;
use App\Models\Organization;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoriesOrganizations extends BaseController
{
    public function __invoke(Request $request){
   
      $subcategory = Subcategory::find($request->subcategory_id)->first();
      if($subcategory){
        $data = Organization::where('subcategory_id',$request->subcategory_id)->paginate(30)->withQueryString();
        return $this->sendResponse(OrganizationsBranchesResource::collection($data),['page_count' => $data->lastPage()],'success');
      }



    }
}
