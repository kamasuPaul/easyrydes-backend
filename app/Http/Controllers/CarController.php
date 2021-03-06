<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarDocuments;
use App\Models\CarLocation;
use App\Models\CarPhoto;
use App\Models\CarPricing;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Get all cars
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 25);
        $paginator = Car::latest()->paginate($perPage);
        return response()->json(my_paginator($paginator));
    }
    /**
     * get car that belong that where listed by a certain user
     */
    public function get_user_cars($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return jsend_fail(['message' => 'A user account with the given id was  not found'], 404);
        }
        return jsend_success($user->cars);
    }
    /**
     * Get details of a single car
     */
    public function get_details($car_id)
    {
        $car = Car::withMedia('photos')->with('documents')->find($car_id);
        //return 404 if the car with  the given id is not found
        if (!$car) {
            return jsend_fail(['message' => 'A car listing with the given id was  not found'], 404);
        }
        return jsend_success($car);
    }
    /**
     * Update a cars details
     */
    public function update(Request $request, $car_id)
    {
        # code...
    }
    /**
     * Delete an existing car
     */
    public function destroy(Request $request, $car_id)
    {
        # code...
        return jsend_success([
            'message' => 'Car successfully deleted',
        ], 201);
    }
    /**
     * Create a new car
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'VIN' => 'required|string|between:2,50',
            'make_id' => 'required',
            'color' => 'required|string|between:2,50',
            'plate_number' => 'required|string|max:100|unique:listings',
            'year' => 'required|integer|min:1900|max:2099',
            'description' => 'required|string',
            'allowable_miles' => 'string',
            'speed_meter' => 'string|required',
            //validate location
            'location.lat' => 'numeric|required',
            'location.long' => 'numeric|required',
            'location.place_name' => 'string|required',
            //validate price
            'price_per_day' => 'numeric|required',
            'price_per_week' => 'numeric|required',
            'price_per_month' => 'numeric|required',
            
        ]);

        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 400);
        }
        //check if the request contains images && validate them
        if ($request->has('photos')) {
            $request->validate([
                'photos.*'     =>  'required|integer|exists:media,id',
            ]);
        }
        //check if the request contains documents && validate them
        if ($request->has('documents')) {
            $request->validate([
                'documents.proof_of_registration'     =>  'required|image|mimes:jpeg,png,jpg|max:2048',
                'documents.proof_of_insurance'     =>  'required|image|mimes:jpeg,png,jpg|max:2048',
                'documents.proof_of_inspection'     =>  'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        }



        //add database transaction to save all the data
        try {
            //begin the transaction
            DB::beginTransaction();
            $car = Car::create([
                'VIN' => $request->VIN,
                'color' => $request->color,
                'plate_number' => $request->plate_number,
                'year' => $request->year,
                'description' => $request->description,
                'allowable_miles' => $request->allowable_miles?:200,
                'speed_meter' => $request->speed_meter,
                'user_id' => auth()->user()->id,
                'status' => 'available',
            ]);
            //save the photos
            if ($request->has('photos')) {
                //loop through all uploaded car photos
                $photos = $request->input('photos');
                // dd($photos);
                $car->attachMedia($photos, 'photos');
                //update the car suchthat the first photo becomes the preview photo
                // $car->preview_photo = $file_path;
                $car->save();
            }
            //save the location 
            $location = new CarLocation();
            $location->longitude = $request->input('location.long');
            $location->latitude = $request->input('location.lat');
            $location->location_name = $request->input('location.place_name');
            $location->listing_id = $car->listing_id;
            $location->save();

            //save the price
            $pricing = new CarPricing();
            $pricing->price_per_day = $request->input('price_per_day');
            $pricing->price_per_week = $request->input('price_per_week');
            $pricing->price_per_month = $request->input('price_per_month');
            $pricing->listing_id = $car->listing_id;
            $pricing->save();

            //save the documents if they are available
            if ($request->has('documents')) {
                $documents = new CarDocuments();
                //store image for proof_of_registration
                $proof_of_reg = $request->file('documents.proof_of_registration');
                $file_path_reg = $proof_of_reg->store('car_documents', 'public');
                $documents->proof_of_registration = $file_path_reg;

                //store image for proof_of_insurance
                $proof_of_ins = $request->file('documents.proof_of_insurance');
                $file_path_ins = $proof_of_ins->store('car_documents', 'public');
                $documents->proof_of_insurance = $file_path_ins;

                //store image for proof_of_inspection
                $proof_of_insp = $request->file('documents.proof_of_inspection');
                $file_path_insp = $proof_of_insp->store('car_documents', 'public');
                $documents->proof_of_inspection = $file_path_insp;

                $documents->listing_id = $car->listing_id;
                $documents->save();
            }
            //commit the transaction
            DB::commit();

            //return response
            return jsend_success([
                'message' => 'Car listing successfully added',
                'car' => $car
            ], 201);
        } catch (Exception $e) {
            //rollback the transaction
            DB::rollback();
            Log::error($e->getMessage());
            return jsend_fail(['message' => 'An error occured while creating the car listing'], 500);
        }
    }
}
