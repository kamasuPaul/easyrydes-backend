<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarPhoto extends Model
{
    use HasFactory;

    protected $table = "photos"; //car photos db table
    protected $primaryKey  = "photo_id"; //primary key
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'listing_id'];


    public function getUrlAttribute($value)
    {
        return  Storage::url($value);
    }
}
