<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function quarters(){
        return $this->hasMany(Quarter::class);
    }
}
