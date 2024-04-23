<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weblink extends Model
{
    use HasFactory;

    public function organizations(){
      return $this->belonsTo(Organization::class,'organization_id');
  }
}
