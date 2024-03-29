<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function districts(){
        return $this->hasMany(District::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
