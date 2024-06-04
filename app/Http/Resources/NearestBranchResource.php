<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Str;

class NearestBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      return  [
        "id"=>$this->id,
        "organization_id"=>$this->organization_id,
        "address"=>$this->address(),
        "telephone"=>$this->telephone,
        "latitude" =>$this->latitude,
        "longitude"=>$this->longitude,
        "work_time"=>$this->working_time(),
        "opend_status"=>$this->checkTime($this->work_time_en),
        "title"=>$this->title(),

    ];





    }


    public function checkTime($string)
    {
      // dd($string);
        // $string="Mon Tue Wed Thu Fri Sat 10:00-18:00";
        // $string="Mon Tue Wed Thu Fri 09:00-19:00Sat 09:00-18:00";
        // $string="Mon Tue Wed Thu Fri Sat Sun 24 hours";
        // dd($string);
        // Get the current day and time
        $now = Carbon::now();
        $day = $now->format('D'); // e.g., Mon, Tue, Wed, etc.
        $time = $now->format('H:i'); // Current time in HH:MM format

        $allowedDays = explode(' ',$string);
        $startTime = '';
        $endTime = '';
        $opend_status='';
// dd($allowedDays[5]);
        if(preg_match('/(\d{2}:\d{2})-(\d{2}:\d{2})/', $allowedDays[5], $matches)){
          // dd($allowedDays[5]);

          return $this->check_string($string, $opend_status);
        }else{

          if (in_array($day, $allowedDays)) {

            if (Str::contains($string, "-")) {
              // dd(888);
              $string_explode  =explode('-',$string);

              // dd($string_explode[0]);
              $pattern = '/\b([01]?[0-9]|2[0-3]):[0-5][0-9]\b/';
              preg_match_all($pattern, $string_explode[0], $matches);

              $startTime = $matches[0][0];

              $endTime = $string_explode[1];
              // dd($time,$startTime,$endTime);
              // Check if the current time is within the allowed range
                if ($time >= $startTime && $time <= $endTime) {
                  return $this->opened();

                  // if(app()->getLocale()=='am'){
                  //   return $opend_status="Բաց է";
                  // }
                  // elseif(app()->getLocale()=='ru'){
                  //   return $opend_status="Открыть";
                  // }else{

                  //   return $opend_status="Open";
                  // }

                }else{
                  return $this->closed();

                  // if(app()->getLocale()=='am'){
                  //   return $opend_status="Փակ է";
                  // }
                  // elseif(app()->getLocale()=='ru'){
                  //   return $opend_status="Закрывать";
                  // }else{
                  //   return $opend_status="Close";
                  // }

                }

            }
            if (Str::contains($string, 24)) {

              return $this->opened();

              // if(app()->getLocale()=='am'){
              //   return $opend_status="Բաց է";
              // }
              // elseif(app()->getLocale()=='ru'){
              //   return $opend_status="Открыть";
              // }else{
              //   return $opend_status="Open";
              // }

            }


          }
      }


        return $opend_status=null;
    }
    public function opened(){

      if(app()->getLocale()=='am'){
        return $opend_status="Բաց է";
      }
      elseif(app()->getLocale()=='ru'){
        return $opend_status="Открыть";
      }else{
        return $opend_status="Open";
      }

    }
    public function closed(){

      if(app()->getLocale()=='am'){
        return $opend_status="Փակ է";
      }
      elseif(app()->getLocale()=='ru'){
        return $opend_status="Закрывать";
      }else{
        return $opend_status="Close";
      }


    }

    public function check_string($string,$opend_status){
dd($opend_status);
        dd(5559);
        return $opend_status=null;

    }
}
