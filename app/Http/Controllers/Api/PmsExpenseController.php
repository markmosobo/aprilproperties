<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsExpense;
use Carbon\Carbon;

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

    public function propertyExpenses(Request $request, $id)
    {
        $pmspropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmspropertyexpenses' => $pmspropertyexpenses
        ], 200);
    } 

    public function propertyLastMonthExpenses(Request $request, $id)
    {
        $pmslastmonthpropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthpropertyexpenses' => $pmslastmonthpropertyexpenses
        ], 200);
    }

    public function propertyLastNinetyExpenses(Request $request, $id)
    {
        $pmslastninetypropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetypropertyexpenses' => $pmslastninetypropertyexpenses
        ], 200);
    }

    public function propertyYearExpenses(Request $request, $id)
    {
        $pmsyearpropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyearpropertyexpenses' => $pmsyearpropertyexpenses
        ], 200);
    }

    public function propertyQuarterExpenses(Request $request, $id)
    {
        $pmsquarterpropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquarterpropertyexpenses' => $pmsquarterpropertyexpenses
        ], 200);
    }

    public function propertyLastYearExpenses(Request $request, $id)
    {
        $pmslastyearpropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyearpropertyexpenses' => $pmslastyearpropertyexpenses
        ], 200);
    }

    public function propertyAllExpenses(Request $request, $id)
    {
        $pmspropertyexpenses = PmsExpense::with('user','unit','property')->where('pms_property_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmspropertyexpenses' => $pmspropertyexpenses
        ], 200);
    }       

}
