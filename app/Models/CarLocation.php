<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarLocation extends Model
{
    use HasFactory;

    protected $table = "locations"; //car locations db table
    protected $primaryKey  = "location_id"; //primary key

    protected $hidden = ['created_at', 'updated_at', 'listing_id'];
    protected $fillable = [
        'longitude',
        'latitude',
        'location_name',
        'listing_id',
    ];
}
