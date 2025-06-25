<?php

namespace App\Services;

use App\Models\Asset;


class AssetService{

    public function getListByCategory($category){
        return Asset::where('category_id',$category)->get();
    }
}
