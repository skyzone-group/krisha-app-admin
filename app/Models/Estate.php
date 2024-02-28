<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_type',
        'region_id',
        'district_id',
        'quarter_id',
        'underground_id',
        'latitude',
        'longitude',
        'is_owner',
        'is_new',
        'home_number',
        'room_count',
        'floor',
        'floor_count',
        'total_area',
        'kitchen_area',
        'land_area',
        'land_area_type',
        'comment',
        'build_year',
        'currency',
        'price',
        'transaction_type',
        'is_barter',
        'is_negotiable',
        'video',
        'ceiling_height',
        'bathroom_count',

        'price_type',
        'is_home_number_hidden',
    ];

    public function images()
    {
        return $this->hasMany(Image::class,'estate_id','id');
    }

    public function region()
    {
        return $this->BelongsTo(Region::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class,);
    }

    public function quarter()
    {
        return $this->hasOne(Quarter::class,'id','quarter_id');
    }
    public function underground()
    {
        return $this->BelongsTo(Underground::class);
    }

    public function keys()
    {
        return $this->hasMany(KeyItemValue::class,'estate_id','id');
    }
}
