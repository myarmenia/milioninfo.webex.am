<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryEditController extends Controller
{
    public function edit($id){


      $data = Category::find($id);


        return view('content.category.edit',compact('data'));
      }



  }
