<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use App\Traits\CoordinateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory, CoordinateTrait, Searchable;


    protected  $searchable = [
      'organizations.name_am',
      'organizations.name_ru',
      'organizations.name_en',
      // 'latitude',
      // 'longitude',
      'address_am',
      'address_ru',
      'address_en',
      'title_am',
      'title_ru',
      'title_en',

  ];
    public function organizations(){

      return $this->belongsTo(Organization::class,'organization_id');
  }

  public  function address(){

      $address='address_'.app()->getLocale();

      return $this->$address;

  }
  public  function title(){

      $title='title_'.app()->getLocale();

      return $this->$title;

  }
  public  function working_time(){

    $work_time='work_time_'.app()->getLocale();

    return $this->$work_time;

}
//   public function scopeSearch(Builder $builder,$searched_word='', $latitude='', $longitude=''){


//      foreach($this->searchable as $searchable){

//         if(str_contains($searchable,'.')){

//             $relation = Str::beforeLast($searchable, '.');
//             $column = Str::afterLast($searchable, '.');



//               if($searched_word!=null){

//                 $words = explode(' ', $searched_word);

//                 foreach( $words as $word){

//                   if(!empty($word)){

//                     $builder->orWhereRelation($relation, $column, 'like', '%'.$word.'%');
//                   }
//                 }
//                 // dd($builder->get());
//               }

//         }else{


//           if($searched_word!=null){
//             $single_search = explode(' ', $searched_word);

//             foreach( $single_search as $item){
//               if($searchable!='latitude' || $searchable!='longitude' ){
//                 if(!empty($item)){

//                   $builder->orWhere($searchable,'like','%'.$item.'%');
//                 }
//               }

//             }

//           }

//         }


//     }

// }



    public function toSearchableArray()
    {

        // $array = [
        //     'id' => $this->id,
        //     'address_am' => $this->address_am,
        //     'address_en' => $this->address_en,
        //     'address_ru' => $this->address_ru,
        //     'title_am' => $this->title_am,
        //     'title_en' => $this->title_en,
        //     'title_ru' => $this->title_ru,
        // ];
        $array = $this->toArray();
        $array['organizations'] = $this->organizations;
     

        return $array;
    }



}
