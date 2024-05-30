<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategorySubcategoryResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;

class CategorySubcategoryController extends BaseController
{
    public function __invoke(Request $request)
    {

      $category = Category::find($request->category_id);
      $data = $category->subcategories->pluck('organizations')->flatten();
// $subcategories = $category->subcategories->pluck('id');
// $organizations = Organization::whereIn('subcategory_id',$subcategories)->get();
// $organizations = Organization::whereIn('subcategory_id',$subcategories)->get();

       return OrganizationResource::collection($data);
    }
}
