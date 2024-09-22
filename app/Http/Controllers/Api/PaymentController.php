<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payment = Payment::create([
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'transfer_type' => $request->transfer_type,
            'paybill' => $request->paybill
        ]);

        return response()->json([
            'status' => true,
            'message' => "Payment Created successfully!",
            'payment' => $payment
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Payment Updated successfully!",
            'payment' => $payment
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        if($payment){
        $payment->delete();

        return response()->json([
            'status' => true,
            'message' => "Payment Deleted successfully!",
        ], 200);
        }
    }

    public function single(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'payment' => $payment
        ], 200);
    }
}
