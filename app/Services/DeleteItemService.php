<?php

namespace App\Services;


use App\Services\Log\LogService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeleteItemService
{
  public static function delete($tb_name, $id)
  {

      $className = 'App\Models\\' . Str::studly(Str::singular($tb_name));
      $model = '';

      if(class_exists($className)) {
          $model = new $className;
      }


      if(!is_string($model)){

          $item = $model->where('id', $id);


          $item_db = $item->first();
          
          if(isset($item_db->path)){
            Storage::disk('public')->deleteDirectory("$tb_name/$id");

          }


          $delete = $item ? $item->delete() : false;




      return $delete;
      }

  }
}
