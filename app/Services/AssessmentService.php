<?php

namespace App\Services;

use App\Models\Assessmentdata;

class AssessmentService{

    public function storeAssessment($data){
        return Assessmentdata::create($data);
    }

    public function listAssessmentsByTaxpayerId($taxpayer_id){
        return Assessmentdata::where('taxpayer_id',$taxpayer_id)->get();
    }
    public function listAllAssessments(){
        return Assessmentdata::get();
    }
}
