<?php

namespace App\Http\Controllers\Admin\CategorySubcategory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategorySubcategoryEditController extends Controller
{
  public function edit($id){


    $category = Category::find($id);
    $subcategories=Subcategory::all();


      return view('content.category-subcategory.edit',compact('category','subcategories'));
    }

}
