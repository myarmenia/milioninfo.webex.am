<?php

if(!function_exists('languages')){
    function languages(){
        // return Language::all();
        return [
          'am','ru','en'
        ];

    }
}
if(!function_exists('countCordinate')){
  function countCordinate($latitude,$longitude){

    $initialLatitude =$latitude;
    $initialLongitude = $longitude;
    $radius = 1000;//metter
    // Calculate new latitude and longitude
  // Constants for latitude and longitude conversion
  $latitudeDegreeLength = 111000;
  $longitudeDegreeLength = 111000 * cos(deg2rad($initialLatitude));

  // Calculate latitude offset
  $latitudeOffset = $radius / $latitudeDegreeLength;

  // Calculate longitude offset
  $longitudeOffset = $radius / $longitudeDegreeLength;

  // Calculate new latitude and longitude
  $newLatitude = $initialLatitude + ($latitudeOffset * (180 / M_PI));
  $newLongitude = $initialLongitude + ($longitudeOffset * (180 / M_PI));


  $cordinate_array=[];
  $cordinate_array['latitude'] = $newLatitude;
  $cordinate_array['longitude'] = $newLongitude;

  return $cordinate_array;


  }
}


