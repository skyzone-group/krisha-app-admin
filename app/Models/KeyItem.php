<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyItem extends Model
{
    use HasFactory;

    //itemname
    public function itemname(){
        return $this->hasOne(Item::class, 'id','item_id');
    }
}
