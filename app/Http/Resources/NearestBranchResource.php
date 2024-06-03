<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
        "opend_status"=>$this->getWeekDays($this->working_time()),
        "title"=>$this->title(),

    ];





    }
    public function  getWeekDays($working_time)
    {
      // dd($working_time);
        $weekDays = [];
        $current = Carbon::now()->startOfWeek();
// dd($current);
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = [
                'day' => $current->copy()->format('l'),
                'date' => $current->copy()->toDateString()
            ];
            $current->addDay();

        }
        // dd($weekDays);
$shortDay = Carbon::now()->format('D');
// dd($shortDay);
$pattern = '/^(Mon Tue Wed Thu Fri Sat Sun)+ (\d{2}:\d{2}-\d{2}:\d{2})$/';
dd($pattern);
// Use preg_match to find the working hours and days in the string
if (preg_match($pattern, $text, $matches)) {
    // $matches[1] contains the days
    // $matches[2] contains the time range

    $days = $matches[1];
    $timeRange = $matches[2];

    // Explode the days by space
    $daysArray = explode(' ', $days);

    // Explode the time range by '-'
    list($startTime, $endTime) = explode('-', $timeRange);

    return [
        'days' => $daysArray,
        'start_time' => $startTime,
        'end_time' => $endTime,
    ];
} else {
    return null; // Invalid format
}
        return response()->json($weekDays);
    }


}
