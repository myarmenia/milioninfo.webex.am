<?php

namespace App\Traits;

use App\Models\EventConfig;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Services\FileUploadService;
use App\Services\Log\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UpdateTrait
{
  abstract function model();

  public function itemUpdate(Request $request, $id)
  {

    $data = $request->except(['translate', 'photo', '_method']);

    $className = $this->model();

    if (class_exists($className)) {

      $model = new $className;
      $relation_foreign_key = $model->getForeignKey();

      $table_name = $model->getTable();

      $item = $model::where('id', $id)->first();
      $item->update($data);
      if ($item) {
        if ($request['translate'] != null) {
          foreach ($request['translate'] as $key => $lang) {

            $item->item_translations()->where([$relation_foreign_key => $id, 'lang' => $key])->update($lang);
          }

        }

        if (isset($request['photo'])) {
          if($item->path!=null){
            
            if(Storage::exists( $item->path)) {

              Storage::delete($item->path);
            }

          }



          $path = FileUploadService::upload($request['photo'], $table_name . '/' . $id);
          $item->path = $path;
          $item->save();

        }
        return true;
      }
    } else {

      return false;
    }
  }

}
