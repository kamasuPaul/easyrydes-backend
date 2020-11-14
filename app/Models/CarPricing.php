<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPricing extends Model
{
    use HasFactory;

    protected $table = "pricings"; //car price db table
    protected $primaryKey  = "location_id"; //primary key
    protected $hidden = ['created_at', 'updated_at', 'listing_id'];
    protected $fillable = [
        'duration',
        'price_per_day',
        'price_per_week',
        'price_per_month',
        'listing_id',
    ];
}
