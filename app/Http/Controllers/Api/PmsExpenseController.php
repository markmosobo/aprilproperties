<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsExpense;

class PmsExpenseController extends Controller
{
    public function store(Request $request)
    {
         $orgDate = now();
         $date = str_replace('-"', '/', $orgDate);
         $newDate = date("YmdHis", strtotime($date));
        $refno = "IPMC".$newDate;
        $expense = PmsExpense::create([
            'pms_unit_id' => $request->pms_unit_id,
            'pms_property_id' => $request->pms_property_id,
            'payment_type' => $request->payment_type,
            'amount_paid' => $request->amount_paid,
            'paid_to' => $request->paid_to,
            'checked_by' => $request->checked_by,
            'ref_no' => $refno,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Expense Created successfully!",
            'expense' => $expense
        ], 200); 
    }

    public function update(Request $request,  $id)
    {
        $expense = PmsExpense::findOrFail($id);
        $expense->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Expense Updated successfully!",
            'expense' => $expense
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $expense = PmsExpense::findOrFail($id);
        if($expense){
        $expense->delete();

        return response()->json([
            'status' => true,
            'message' => "Expense Deleted successfully!",
        ], 200);
        }
    } 

    public function single(Request $request, $id)
    {
        $pmsexpense = PmsExpense::with('user','unit','property')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "retreived",
            'pmsexpense' => $pmsexpense
        ], 200);
    }       

}
