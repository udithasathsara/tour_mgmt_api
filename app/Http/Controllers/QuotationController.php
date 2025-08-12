<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Models\Itinerary;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuotationController extends Controller
{
    //
    public function index()
    {
        $query = Quotation::query();

        // Agent sees only their quotations
        if (auth()->user()->role === 'agent') {
            $query->whereHas('itinerary', function ($q) {
                $q->where('agent_id', auth()->id());
            });
        }

        return $query->paginate(15);
    }

    public function store(StoreQuotationRequest $request)
    {
        // Get itinerary with authorization check
        $itinerary = Itinerary::findOrFail($request->itinerary_id);

        // Authorization moved here
        if (!(auth()->user()->role === 'admin' ||
            $itinerary->agent_id === auth()->id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to create quotation for this itinerary'
            ], 403);
        }

        // Create quotation
        $quotation = Quotation::create([
            'id' => Str::uuid(),
            ...$request->validated()
        ]);

        return response()->json($quotation, 201);
    }

    public function show(Quotation $quotation)
    {
        // Authorization handled in request
        return $quotation;
    }

    public function publicShow($uniqueId)
    {
        $quotation = Quotation::findOrFail($uniqueId);
        return response()->json($quotation);
    }
}
