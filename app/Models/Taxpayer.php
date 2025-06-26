<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxpayer extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function assets(){
        return $this->hasMany(Asset::class, 'taxpayer_id');
    }
}
