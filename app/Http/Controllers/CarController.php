<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarLocation;
use App\Models\CarPhoto;
use App\Models\CarPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Get all cars
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 25);
        $paginator = Car::paginate($perPage);
        return response()->json(my_paginator($paginator));
    }
    /**
     * Get details of a single car
     */
    public function get_details($user_id)
    {
        $car = Car::with('photos')->find($user_id);
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
    public function delete(Request $request, $car_id)
    {
        # code...
        return jsend_success([
            'message' => 'Car successfully deleted',
        ], 201);
    }
    /**
     * Create a new car
     */
    public function create_new_car(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'VIN' => 'required|string|between:2,50',
            'make_id' => 'required|string',
            'color' => 'required|string|between:2,50',
            'plate_number' => 'required|string|max:100|unique:listings',
            'year' => 'required|string',
            'description' => 'required|string',
            'allowable_miles' => 'string',
            'status' => 'string',
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
                'photos.*'     =>  'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        }

        $car = Car::create($validator->validated());

        //save the photos
        if ($request->hasFile('photos')) {
            //loop through all uploaded car photos
            $photos = $request->file('photos');
            foreach ($photos as $photo) {
                $file_path = $photo->store('car_photos', 'public');
                $photo = new CarPhoto();
                $photo->url = $file_path;
                $photo->listing_id = $car->listing_id;
                $photo->save();
            }
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

        return jsend_success([
            'message' => 'Car listing successfully added',
            'car' => $car
        ], 201);
    }
}
