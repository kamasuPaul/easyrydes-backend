<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
    public function get_details()
    {
        # code...
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
        ]);

        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 400);
        }

        $car = Car::create($validator->validated());

        return jsend_success([
            'message' => 'Car listing successfully added',
            'car' => $car
        ], 201);
    }
}
