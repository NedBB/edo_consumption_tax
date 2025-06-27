<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Taxpayer extends Authenticatable
{
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isManager(): bool
    {
        return $this->type === 'manager';
    }

    public function isRegularUser(): bool
    {
        return $this->type === 'user';
    }
    public function assets(){
        return $this->hasMany(Asset::class, 'taxpayer_id');
    }
}
