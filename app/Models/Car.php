<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = "listings"; //car db table
    protected $primaryKey  = "listing_id"; //primary key
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
    protected $with = ['location', 'pricing'];
    /**
     * car photos relationship
     */
    public function photos()
    {
        return $this->hasMany('App\Models\CarPhoto', 'listing_id', 'listing_id');
    }
    /**
     * car location relationship
     */
    public function location()
    {
        return $this->hasOne('App\Models\CarLocation', 'listing_id', 'listing_id');
    }
    /**
     * car pricing relationship
     */
    public function pricing()
    {
        return $this->hasOne('App\Models\CarPricing', 'listing_id', 'listing_id');
    }
    /**
     * car documents relationship
     */
    public function documents()
    {
        return $this->hasOne('App\Models\CarDocuments', 'listing_id', 'listing_id');
    }
}
