<?php

namespace App\Traits;
use Illuminate\Support\Str;
use Carbon\Carbon;


trait CheckOpendClosedTrait {
  public function checkTime($string,$id)
    {

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

        return $this->get_working_times($string, $now, $day, $time);

    }
    public function get_working_times($string, $now, $day, $time){

      if(Str::contains("$string","24 hours")){

          return $this->opened();
      }

      preg_match_all('/([A-Za-z]{3})|(\d{2}:\d{2}-\d{2}:\d{2})/', $string, $matches);

      // Initialize an array to store the results
      $schedule = [];
      $current_days = [];
      // Iterate through the matches to build the schedule
      foreach ($matches[0] as $match) {

          if (preg_match('/[A-Za-z]{3}/', $match)) {
              // It's a day
              $current_days[] = $match;

          } elseif (preg_match('/\d{2}:\d{2}-\d{2}:\d{2}/', $match)) {
              // It's a time range

              foreach ($current_days as $days) {

                  $schedule[$days] = $match;

              }
              // Reset current days after adding time range
              $current_days = [];
          }
          // dump($current_days);
      }

      // Print the schedule

      $current_days_array=[];
      foreach($schedule as $key1=>$item1){
        array_push($current_days_array,$key1);
      }

      if(in_array($day,$current_days_array)){

        foreach($schedule as $key=>$item){

          if($day == $key){
            $explode_item = explode('-',$item);
            $startTime = $explode_item[0];

            $endTime = $explode_item[1];

              return $this->check_time_opend_cloced($time,$startTime,$endTime);
          }

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
