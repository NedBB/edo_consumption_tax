<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function asset(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
