<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Profile;


class AssetService{



    public function getListByCategory($category){
        return Asset::where('category_id',$category)->get();
    }

    public function getAssetByTaxpayerId($taxpayer_id){
        return Asset::where('taxpayer_id',$taxpayer_id)->get();
    }

    public function getProfileByAssetId($asset_id){
        return Profile::where('asset_id',$asset_id)->first();
    }
}
