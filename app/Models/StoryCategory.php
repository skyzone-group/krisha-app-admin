<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryCategory extends Model
{
    protected $guarded = ['id'];

    public function public_path():string
    {
        return public_path()."/files/";
    }

    public function path():string
    {
        return "/files/".$this->photo;
    }

    public function absolute_path():string
    {
        return public_path().'/files/'.$this->photo;
    }

    public function remove()
    {
        # Delete all releated thins to product

        \Illuminate\Support\Facades\File::delete($this->absolute_path());
        return $this->delete();
    }
}
