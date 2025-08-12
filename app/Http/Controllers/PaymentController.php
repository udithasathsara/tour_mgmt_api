<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Quotation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Payment::query();

        // Filters
        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->assigned_to) {
            $query->whereHas('quotation.itinerary', function ($q) use ($request) {
                $q->where('agent_id', $request->assigned_to);
            });
        }

        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        // Agent sees only their payments
        if (auth()->user()->role === 'agent') {
            $query->whereHas('quotation.itinerary', function ($q) {
                $q->where('agent_id', auth()->id());
            });
        }

        return $query->paginate(15);
    }

    public function store(StorePaymentRequest $request)
    {
        // Get quotation with authorization check
        $quotation = Quotation::findOrFail($request->quotation_id);

        // Authorization: Admin or assigned agent
        if (!(auth()->user()->role === 'admin' ||
            $quotation->itinerary->agent_id === auth()->id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to create payment for this quotation'
            ], 403);
        }

        // Create payment
        $payment = Payment::create($request->validated());

        return response()->json($payment, 201);
    }
}
