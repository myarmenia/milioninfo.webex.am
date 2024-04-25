<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\CoordinateTrait;
use Illuminate\Http\Request;

class GetCordinateController extends Controller
{
  use CoordinateTrait;
    public function __invoke(Request $request) {

      $coordinate=$this->countCordinate($request->latitude,$request->longitude);
        dd($coordinate);
    }
}
