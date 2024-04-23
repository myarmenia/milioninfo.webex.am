<?php
namespace App\Traits\Category;

use App\Models\Category;

 trait GetCategoryTrait {

    public function scopegetCategory(){
        $category=Category::all();
        return $category;
    }


 }
