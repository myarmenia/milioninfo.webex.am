<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\BranchesOrganizationResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Branch;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;

class SearchedAddressController extends BaseController
{
    public function index(Request $request){
        // dd($request['searched_word']);
        // dd($request['address']);
        $data = Organization::where('name_am','like','%'.$request['searched_word'].'%')->pluck('id')->toArray();
dd($data);
      $branches=Branch::whereIn('organization_id',$data)->get();
      // dd($branches);
      $branch_array=[];
      foreach($branches as $value){
// dd($value);
        if(str_contains($value->address_am,$request['searched_word'])){
          array_push( $branch_array, $value->id);
          // dd($value->address_am);
        }
        // print_r($value->title_am);
        if(str_contains($value->title_am,$request['searched_word'])){
          // dd($request['address']);
          array_push( $branch_array, $value->id);
          // dd($value->address_am);
        }

      }
      dd($branch_array);


      $branches_org=Branch::whereIn('id',$branch_array)->get();
      // dd($branches_org);
      // dd($branch_array);
        return $this->sendResponse(BranchesOrganizationResource::collection( $branches_org),'success');
    }
}
