<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Get all cars
     */
    public function index()
    {
        # code...
        return jsend_success([], 200);
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
        # code...
        return jsend_success([
            'message' => 'Car successfully added',
            'car' => (object)[]
        ], 201);
    }
}
