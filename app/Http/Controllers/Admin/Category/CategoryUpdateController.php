<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\UpdateTrait;
use Illuminate\Http\Request;

class CategoryUpdateController extends Controller
{
  use UpdateTrait;
  // public function __construct()
	// {
  //   $this->middleware('role:museum_admin|content_manager');
  //   $this->middleware('product_viewer_list');

	// }
    public function model()
    {
      return Category::class;
    }
    public function update(CategoryRequest $request, string $id){

      $data = $this->itemUpdate($request,$id);

      if($data){

        return redirect()->back();

      }
    }
}
