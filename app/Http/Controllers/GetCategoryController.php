<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class GetCategoryController extends BaseController
{
    /**
     * Handle the incoming request.
     */
    protected $model;
    public function __construct(Category $model)
	{

		$this->model = $model;
	}
    public function __invoke(Request $request)
    {

      $category = $this->model->getCategory();

      return $this->sendResponse(CategoryResource::collection($category),'success');
    }
}
