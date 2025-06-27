<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessmentdata extends Model
{

    protected $fillable = [
        'taxpayer_id',
        'taxpayer_type_id',
        'asset_type_id',
        'asset_id',
        'profile_id',
        'assessment_rule_id',
        'tax_year',
        'tax_amount',
        'notes',
        'reference_code',
        'status'
    ];

}
