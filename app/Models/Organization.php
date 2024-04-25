<?php

namespace App\Models;

use App\Traits\CoordinateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory , CoordinateTrait;
    protected  $searchable = [
      'name_en',
      'name_am',
      'name_ru',
      'branches.latitude',
      'branches.longitude',
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
  public function scopeSearch(Builder $builder,$searched_word='', $latitude='', $longitude=''){


      foreach($this->searchable as $searchable){

          if(str_contains($searchable,'.')){
              $relation = Str::beforeLast($searchable, '.');
              $column = Str::afterLast($searchable, '.');

              $builder->orWhereRelation($relation, $column, 'like', '%'.$searched_word.'%');

              if($latitude!=null && $longitude!=null){

                $coordinate=$this->countCordinate($latitude,$longitude);
                $builder->whereRelation($relation, 'latitude', '<=', $coordinate['latitude']);
                $builder->whereRelation($relation, 'longitude', '<=', $coordinate['longitude']);
              }

              continue;
          }

          $builder->orWhere($searchable,'like','%'.$searched_word.'%');
      }
      // dd($builder->get());
      dd($builder->toSql());
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
