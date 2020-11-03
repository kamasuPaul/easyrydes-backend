<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = "listings"; //car db table
    protected $fillable = [ //mass assignable fields
        'VIN',
        'color',
        'plate_number',
        'year',
        'description',
        'allowable_miles',
        'status',
        'model_id',
        'speed_meter'
    ];
    /**
     * car photos relationship
     */
    public function photos()
    {
    }
}
