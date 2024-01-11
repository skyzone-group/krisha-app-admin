<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Key extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    //items
//    public function items(){
//        return $this->hasMany(KeyItem::class, 'key_id','id');
//    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'key_items', 'key_id', 'item_id');
    }
}
