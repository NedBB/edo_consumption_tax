<?php

namespace App\Services;

use App\Models\Taxpayer;


class TaxpayerService{

   public function getListByCategory($category){
        return Taxpayer::where('category_id',$category)->paginate(20);
    }
}
