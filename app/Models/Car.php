<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'speed_meter',
        'preview_photo',
        'user_id'
    ];
    protected $with = ['location', 'pricing'];
    // protected $appends = ['preview_photo'];
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
    /**
     * get preview phot
     * 
     */
    public function getPreviewPhotoAttribute($value)
    {
        // return $this->photos[0]->url;
        return  Storage::url($value);
    }
    /**
     * car owner relationship
     * it shows the cars owner
     */
    public function owner()
    {
        return $this->hasOne('App\Models\User', 'id', 'listing_id');
    }
}
