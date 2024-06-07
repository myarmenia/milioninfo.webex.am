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
          "telephone"=>$this->telephone=="null"? null:$this->telephone,
          "latitude" =>$this->latitude,
          "longitude"=>$this->longitude,
          "work_time"=>$this->working_time()=="null" ? null : $this->working_time(),
          "opend_status"=>$this->checkTime($this->work_time_en,$this->id),
          "title"=>$this->title(),

      ];

    }


    public function checkTime($string,$id)
    {
      // dd($string);
        // $string="Mon Tue Wed Thu Fri Sat 10:00-18:00";
        // $string="Mon Tue Wed Thu Fri 09:00-19:00Sat 09:00-18:00";
        // $string="Mon Tue Wed Thu Fri Sat Sun 24 hours";
        // $string="Mon Tue Wed Thu Fri Sat Sun 10:30-20:30";
        // $string="Mon Tue Wed Thu Fri Sat 09:00-20:00Sun 11:00-19:00";
        // dd($string);
        // =============
        // Get the current day and time
        $now = Carbon::now();
        $day = $now->format('D'); // e.g., Mon, Tue, Wed, etc.
        $time = $now->format('H:i'); // Current time in HH:MM format
        $day="Sun";

        $allowedDays = explode(' ', $string);
        // dd( $allowedDays);
        $startTime = '';
        $endTime = '';
// dd($allowedDays[5]);
        if(isset($allowedDays[5])){
          // dd(55);
          $check_number_in_string = $this->containsNumber($allowedDays[5]);

            if($check_number_in_string==true){
                // dd(66);
               return  $this->check_string_with_time($string,$id);

            }else{
              // dd(77);

                  if (in_array($day, $allowedDays)) {
                    // dd(88,$allowedDays);
                    if (Str::contains($string, "-")) {
                      // dd(888);
                      $string_explode  =explode('-',$string);
                      // dd($string_explode);
                      // dd($string_explode[0]);
                      $pattern = '/\b([01]?[0-9]|2[0-3]):[0-5][0-9]\b/';
                      preg_match_all($pattern, $string_explode[0], $matches);
                      // dd($matches);
                      $startTime = $matches[0][0];

                      $endTime = $string_explode[1];

                      // Check if the current time is within the allowed range
                        if ($time >= $startTime && $time <= $endTime) {

                          return $this->opened();

                        }else{

                          return $this->closed();
                        }

                    }
                    if (Str::contains($string, 24)) {

                      return $this->opened();

                    }

                  }else{

                    // dd(99);
                    return $this->closed();
                  }
                  // return $this->closed();


            }
        }
        // else if(isset($allowedDays[6])){

        // }

    }

    function containsNumber($string) {
      // Regular expression to match any number
      return preg_match('/\d/', $string) === 1;
  }

    public function check_string_with_time($string,$id){
        // dd($string,$id);
        $now = Carbon::now();
        $day = $now->format('D'); // e.g., Mon, Tue, Wed, etc.
        $time = $now->format('H:i'); // Current time in HH:MM format
        // $opend_status='';
        // $day="Sun";

        $allowedDays = ["Mon","Tue", "Wed","Thu","Fri","Sat"];

        $string_explode = explode('Sat',$string);

        $pattern = '/\b([01]?[0-9]|2[0-3]):[0-5][0-9]\b/';
        if (in_array($day, $allowedDays)) {
          if($day!="Sat" ||  $day!="Sun"){

            preg_match_all($pattern, $string_explode[0], $matches);
            // dd($matches);
            $startTime = $matches[0][0];
            // dd($matches[0]);
            $endTime = $matches[0][1];
            // dd($startTime,$endTime);

            return $this->check_time_opend_cloced($time,$startTime,$endTime);


          }
          if($day=="Sat"){
            // dd($id);
              // dd($string_explode[1]);
              $explode_second_part = explode("-",$string_explode[1]);
              $startTime = $explode_second_part[0];
              $endTime = $explode_second_part[1];
              // dd(77);
              return $this->check_time_opend_cloced($time,$startTime,$endTime);
          }
        }else{
          return $this->closed();
        }

    }
    public function check_time_opend_cloced($time,$startTime,$endTime){

      if ($time >= $startTime && $time <= $endTime) {

        return $this->opened();

      }else{

        return $this->closed();
      }

    }

    public function opened(){
      // dd(77);
            if(app()->getLocale()=='am'){
              return "Բաց է";
            }
            elseif(app()->getLocale()=='ru'){
              return "Открыть";
            }else{
              return "Open";
            }

          }
          public function closed(){

            if(app()->getLocale()=='am'){
              return "Փակ է";
            }
            elseif(app()->getLocale()=='ru'){
              return "Закрыто";
            }else{
              return "Close";
            }


          }


}
