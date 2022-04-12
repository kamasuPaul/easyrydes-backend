<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate offer details
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer',
            'amount' => 'required|numeric',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return jsend_fail($validator->errors(), 400);
        }

        $offer = Offer::create([
            'car_id' => $request->car_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
            'user_id' => auth()->user()->id,
        ]);
        //return response
        return jsend_success([
            'message' => 'Offer successfully sent',
            'offer' => $offer
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
