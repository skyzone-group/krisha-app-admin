<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quarter extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function district(){
        return $this->belongsTo(District::class);
    }
}
