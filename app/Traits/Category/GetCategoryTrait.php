<?php
namespace App\Traits\Category;
use GeoKit\Math;

use App\Models\Category;

 trait GetCategoryTrait {

    public function scopegetCategory(){
        $category=Category::all();
        return $category;
    }


 }
