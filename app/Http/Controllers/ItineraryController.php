<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItineraryRequest;
use App\Http\Requests\UpdateItineraryRequest;
use App\Models\Enquiry;
use App\Models\Itinerary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItineraryController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = Itinerary::query();

        if ($request->user()->role === 'agent') {
            $query->where('agent_id', $request->user()->id);
        }

        return $query->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItineraryRequest $request)
    {
        $enquiry = Enquiry::find($request->enquiry_id);

        if (!($enquiry->assigned_agent_id === $request->user()->id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only assigned agent can create itinerary'
            ], 403);
        }
        //
        $itinerary = Itinerary::create([
            'enquiry_id' => $request->enquiry_id,
            'agent_id' => $request->user()->id,
            'title' => $request->title,
            'notes' => $request->notes,
            'days' => $request->days
        ]);


        return response()->json($itinerary, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itinerary $itinerary)
    {
        //
        $this->authorize('view', $itinerary);
        return $itinerary;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItineraryRequest $request, Itinerary $itinerary)
    {
        if (!(auth()->user()->role === 'admin' ||
            $enquiry->assigned_agent_id === auth()->id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update enquiry status'
            ], 403);
        }
        //
        $itinerary->update($request->validated());
        return response()->json($itinerary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itinerary $itinerary)
    {
        Log::info('Test log entry for Telescope');
        //
        $this->authorize('delete', $itinerary);
        $itinerary->delete();
        return response()->json(null, 204);
    }
}
