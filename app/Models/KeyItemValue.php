<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyItemValue extends Model
{
    use HasFactory;

    public function key()
    {
        return $this->belongsTo(Key::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
