<?php

namespace App\Models;

use App\Traits\CoordinateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory , CoordinateTrait ;
    protected  $searchable = [
      'name_am',
      'name_ru',
      'name_en',
      'branches.latitude',
      'branches.longitude',
      'branches.address_am',
      'branches.address_ru',
      'branches.address_en',
      'branches.title_am',
      'branches.title_ru',
      'branches.title_en',
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
              if($relation=="branches" && ($column=='latitude' || $column=='longitude' )){

                if($latitude!=null && $longitude!=null){
                  $coordinate = $this->countCordinate($latitude,$longitude);

                  $builder->whereRelation('branches',function($query) use ($coordinate){
                    $query->where('latitude', '<=', $coordinate['latitude'])
                   ->where('longitude', '<=', $coordinate['longitude']);
                  });

                };
              }

                if($searched_word!=null){
                  $words = explode(' ', $searched_word);

                  foreach( $words as $word){
                    if(!empty($word)){

                      $builder->orWhereRelation($relation, $column, 'like', '%'.$word.'%');
                    }
                  }


                }

          }else{
            if($searched_word!=null){
              $single_search = explode(' ', $searched_word);

              foreach( $single_search as $item){

                if(!empty($item)){

                  $builder->orWhere($searchable,'like','%'.$item.'%');
                }

              }

            }

          }


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
  public function nearest_branch_cordinate($latitude,$longitude){
    dd(4444);
      }
}
