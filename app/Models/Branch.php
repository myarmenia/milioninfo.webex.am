<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    public function organizations(){
      return $this->belonsTo(Organization::class,'organization_id');
  }
  public  function address(){

      $address='address_'.app()->getLocale();

      return $this->$address;

  }
  public  function title(){

      $title='title_'.app()->getLocale();

      return $this->$title;

  }
}
