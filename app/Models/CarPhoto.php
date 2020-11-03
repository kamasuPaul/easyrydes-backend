<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPhoto extends Model
{
    use HasFactory;

    protected $table = "photos"; //car photos db table
    protected $primaryKey  = "photo_id"; //primary key
    protected $guarded = [];
}
