<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnquiryRequest $request)
    {
        Log::info('This is an info message');

        $enquiry = Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'travel_start_date' => $request->travel_start_date,
            'travel_end_date' => $request->travel_end_date,
            'number_of_people' => $request->number_of_people,
            'preferred_destinations' => $request->preferred_destinations,
            'budget' => $request->budget,
            'status' => 'pending'
        ]);

        // Log to Telescope
        Log::debug('New enquiry created', $enquiry->toArray());

        return response()->json([
            'status' => 'success',
            'message' => 'Enquiry submitted successfully',
            'data' => $enquiry
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
