<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'currency_id',
        'price',
        'transaction_type',
        'is_barter',
        'is_negotiable',
        'video',
        'ceiling_height',
        'bathroom_count',
    ];

    public function images()
    {
        return $this->hasMany(Image::class,'estate_id','id');
    }

    public function region()
    {
        return $this->hasOne(Region::class,'id','region_id');
    }

    public function district()
    {
        return $this->hasOne(District::class,'id','district_id');
    }

    public function quarter()
    {
        return $this->hasOne(Quarter::class,'id','quarter_id');
    }
    public function underground()
    {
        return $this->hasOne(Underground::class,'id','underground_id');
    }

}
