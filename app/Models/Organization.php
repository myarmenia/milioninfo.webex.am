<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Organization extends Model
{
    use HasFactory;
    protected  $searchable = [

      'name_en',
      'name_am',
      'name_ru',
  ];
  public function subcategories() {
      return $this->belongsTo(Subcategory::class,'subcategory_id');
  }
  public function weblinks() {
      return $this->hasOne(Weblink::class);
  }
  public function branches() {
      return $this->hasMany(Branch::class);
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
  public  function translation(){

      $name='name_'.app()->getLocale();
      return $this->$name;

  }
  public function images() {
    return $this->hasMany(Image::class);
}
}
