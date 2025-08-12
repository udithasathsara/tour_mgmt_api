<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignEnquiryRequest;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\UpdateEnquiryStatusRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Enquiry::query();

        // Apply filters
        if ($request->status) {
            $query->status($request->status);
        }

        if ($request->assigned_to) {
            $query->assignedTo($request->assigned_to);
        }

        if ($request->from && $request->to) {
            $query->dateRange($request->from, $request->to);
        }

        if ($request->search) {
            $query->search($request->search);
        }

        // Authorization filter
        if (auth()->user()->role === 'agent') {
            $query->where('assigned_agent_id', auth()->id());
        }

        return $query->paginate(15);
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


    public function assign(AssignEnquiryRequest $request, Enquiry $enquiry)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only admin can assign enquiries'
            ], 403);
        }

        $enquiry->update(['assigned_agent_id' => $request->agent_id]);

        return response()->json([
            'message' => 'Enquiry assigned successfully',
            'data' => $enquiry
        ]);
    }

    public function updateStatus(UpdateEnquiryStatusRequest $request, Enquiry $enquiry)
    {
        if (!(auth()->user()->role === 'admin' ||
            $enquiry->assigned_agent_id === auth()->id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update enquiry status'
            ], 403);
        }

        Log::info('Test log entry for Telescope');
        $enquiry->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Status updated successfully',
            'data' => $enquiry
        ]);
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
