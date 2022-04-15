<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [ //mass assignable fields
        'listing_id',
        'amount',
        'status',
        'description',
        'expiry_date',
        'user_id',
        'start_date',
        'expiry_date'
    ];
}
