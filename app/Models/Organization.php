<?php

namespace App\Models;

use App\Traits\CoordinateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Organization extends Model
{
    use HasFactory , CoordinateTrait, Searchable;
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
  public  function translation(){

      $name='name_'.app()->getLocale();
      return $this->$name;

  }
    public function images() {
      return $this->hasMany(Image::class);
  }
  public function toSearchableArray()
  {
    $array = $this->toArray();

    return [
            'id' => $array['id'],
            'name_am' => $array['name_am'],
            'name_en' => $array['name_en'],
            'name_ru' => $array['name_ru'],
            'subcategory_id'=>$array['subcategory_id'],
        ];


      // return $array;
  }
}
