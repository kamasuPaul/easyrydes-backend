<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CarDocuments extends Model
{
    use HasFactory;

    protected $table = "car_documents"; //car locations db table
    protected $primaryKey  = "id"; //primary key

    protected $hidden = ['created_at', 'updated_at', 'listing_id'];
    protected $fillable = [
        'proof_of_registration',
        'proof_of_insurance',
        'proof_of_inspection',
        'listing_id',
    ];
    //get the file path for proof_of_registration
    public function getProofOfRegistrationAttribute($value)
    {
        return  Storage::url($value);
    }

    //get the file path for proof_of_insurance
    public function getProofOfInsuranceAttribute($value)
    {
        return  Storage::url($value);
    }
    //get the file path for proof_of_inspection
    public function getProofOfInspectionAttribute($value)
    {
        return  Storage::url($value);
    }
}
