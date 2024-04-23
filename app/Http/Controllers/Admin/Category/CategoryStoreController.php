<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\StoreTrait;
use Illuminate\Http\Request;

class CategoryStoreController extends Controller
{
  use StoreTrait;
  public function model(){

    return Category::class;
  }
  public function store(CategoryRequest $request){

    $category=$this->itemStore($request);

    $categories=Category::where('id','>',0)->with('item_translations')
    ->orderBy('id', 'DESC')->paginate(10)->withQueryString();

    return redirect()->route('category_list');


  }
}
