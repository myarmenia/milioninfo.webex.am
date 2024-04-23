<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory;


    protected  $searchable = [
      'subCategory_am',
      'subCategory_en',
      'subCategory_ru',
      'organizations.name_en',
      'organizations.name_am',
      'organizations.name_ru',
  ];
  public function organizations() {

      return $this->hasMany(Organization::class);
  }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'categories_subcategories','subcategory_id', 'category_id');
    }

  public function scopeSearch(Builder $builder,$searced_word=''){

      foreach($this->searchable as $searchable){
          if(str_contains($searchable,'.')){

              $relation = Str::beforeLast($searchable, '.');
              $column = Str::afterLast($searchable, '.');

              $builder->orWhereRelation($relation, $column, 'like', '%'.$searced_word.'%');

              continue;
          }

          $builder->orWhere($searchable,'like','%'.$searced_word.'%');

      }
      // dd($builder->get());
      // dd($builder->toSql());
      return $builder;

  }
 

}
