<?php

namespace App\Models;

use App\Traits\Category\GetCategoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,GetCategoryTrait;
    protected $table = 'categories';
    public function item_translations(){
      return $this->hasMany(CategoryTranslation::class);
    }

    public function translation($lang){

      return $this->hasOne(CategoryTranslation::class)->where('lang', $lang)->first();
   }
  

   public function subcategories()
   {
       return $this->belongsToMany(Subcategory::class,'categories_subcategories', 'category_id','subcategory_id');
   }


}
