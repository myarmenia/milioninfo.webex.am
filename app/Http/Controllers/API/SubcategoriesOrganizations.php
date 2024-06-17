<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesOrganizationRequest;
use App\Http\Resources\BranchWithOrganizationResource;
use App\Http\Resources\OrganizationsBranchesResource;
use App\Models\Branch;
use App\Models\Organization;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoriesOrganizations extends BaseController
{
    public function __invoke(CategoriesOrganizationRequest $request){

      $latitude = $request->latitude;
      $longitude = $request->longitude;
      $coordinate =countCordinate($latitude,$longitude);

      $subcategory = Subcategory::find($request->subcategory_id);
      if($subcategory!=null){
      $organization_ids = Organization::where('subcategory_id',$subcategory->id)->pluck('id');

      $distance = 1.0; // 1.0 kilometer, which equals 1000 meters
      // dd($organization_ids);
      $data=Branch::whereIn('organization_id',$organization_ids);
    //  dd($data->pluck('id'));
    // if($latitude!=null && $longitude!=null){
    //       $coordinate = countCordinate($latitude,$longitude);

    //       $data->where([
    //         ['latitude', '<=', $coordinate['latitude']],
    //         ['longitude', '<=', $coordinate['longitude']],
    //       ]);

    //     };
      if ($latitude !== null && $longitude !== null) {
        $data = $data->select(
            'branches.*',
            DB::raw("6371 * acos(cos(radians($latitude))
            * cos(radians(latitude))
            * cos(radians(longitude) - radians($longitude ))
            + sin(radians($latitude))
            * sin(radians(latitude))) AS distance")
        )
        ->havingRaw('distance >= ?', [$distance])
        ->orderBy('distance');
        // dd($data);
    }


        $data=$data->paginate(30)->withQueryString();


        return $this->sendResponse(BranchWithOrganizationResource::collection($data),'success', ['page_count' => $data->lastPage()]);

      }

    }
}
