<?php

namespace App\Http\Controllers\Admin\CategorySubcategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorySubcategorySignController extends Controller
{
    public function store(Request $request){

        $category = Category::find($request['category_id']);
        $category->subcategories()->detach();

        $category->subcategories()->attach($request['subcategories']);

        return redirect()->back();
    }
}
