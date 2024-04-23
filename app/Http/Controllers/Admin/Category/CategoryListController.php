<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryListController extends Controller
{
  public function __invoke(Request $request){

    $categories = Category::where('id','>',0)->with('item_translations')
                ->orderBy('id', 'DESC')->paginate(10)->withQueryString();

      return view('content.category.index',compact('categories'))
              ->with('i', ($request->input('page', 1) - 1) * 10);


  }
}
