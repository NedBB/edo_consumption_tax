<?php

namespace App\Services;

use App\Models\Taxpayer;
use Illuminate\Support\Facades\DB;


class TaxpayerService{

   public function getListByCategory($category){
        return Taxpayer::where('category_id',$category)->paginate(20);
    }

    public function getDetailByTaxpayerID($taxpayer_id){
        return Taxpayer::where('taxpayer_id', $taxpayer_id)->with(['user','assets'])->first();
    }

    public function getTaxpayerDetailByUserID($user_id){
        //return Taxpayer::with('assets')->where('user_id', $user_id)->get();
       return DB::table('taxpayers')
                ->join('assets', 'taxpayers.taxpayer_id', '=', 'assets.taxpayer_id')
                ->where('taxpayers.user_id', $user_id)
                ->select('taxpayers.*', 'assets.*')
                ->get();
    }

    public function getTaxpayerIdByUserId($user_id){
        return Taxpayer::with('assets')->where('user_id', $user_id)->get();
    }

    public function getTaxpayerAssessmentByUserID($user_id){
        //return Taxpayer::with('assets')->where('user_id', $user_id)->get();
       return DB::table('taxpayers')
                ->join('assets', 'taxpayers.taxpayer_id', '=', 'assets.taxpayer_id')
                ->join('profiles', 'profiles.asset_id', '=', 'assets.asset_id')
                ->where('taxpayers.user_id', $user_id)
                ->select('taxpayers.taxpayer_id','taxpayers.typeid','assets.asset_id', 'assets.asset_type_id','profiles.profile_id')
                ->get();
    }
}
