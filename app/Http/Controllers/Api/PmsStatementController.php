<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsStatement;
use Carbon\Carbon;

class PmsStatementController extends Controller
{
    public function store(Request $request)
    {
            $startOfMonth = Carbon::now()->startOfMonth();
            $formattedDate = $startOfMonth->format('M Y');
            $orgDate = now();
            $date = str_replace('-"', '/', $orgDate);
            $newDate = date("YmdHis", strtotime($date));
            $refno = "INV".$newDate." ".$request->unit_number." Rent+Deposit @".$request->total;
            // if($request->balance > 0)
            // {
            //     $paystatus = 0;
            // }
            // else
            // {
            //     $paystatus = 1;
            // }
            $pmsstatement = PmsStatement::create([
                'ref_no' => $refno,
                'pms_property_id' => $request->pms_property_id,
                'pms_tenant_id' => $request->pms_tenant_id,
                'details' => "Rent+Deposit - ".$request->unit_number."-".$formattedDate,
                'total' => $request->total,
                'paid' => $request->paid,
                'balance' => $request->balance,
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Statement Created successfully!",
                'pmsstatement' => $pmsstatement
            ], 200);

            
    }

    public function update(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);

        if ($pmsstatement) {
            if($request->balance == 0)
            {
                $pmsstatement->update([
                    'payment_method' => $request->payment_method,
                    'mpesa_code' => $request->mpesa_code,
                    'paid' => $request->paid,
                    'balance' => $request->balance,
                    'status' => 1,
                ]);                
            }
            else
            {
                $pmsstatement->update([
                    'payment_method' => $request->payment_method,
                    'mpesa_code' => $request->mpesa_code,
                    'paid' => $request->paid,
                    'balance' => $request->balance,
                    'status' => 0,
                ]);
            }    
                

            return response()->json([
                'status' => true,
                'message' => "Statement Updated successfully!",
                'statement' => $pmsstatement
            ], 200);
        }
    } 

    public function single(Request $request, $id)
    {
        $pmsstatement = PmsStatement::with('tenant','property')->where('id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsstatement' => $pmsstatement
        ], 200);
    } 

    public function propertyStatements(Request $request, $id)
    {
        $pmspropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmspropertystatements' => $pmspropertystatements
        ], 200);
    }

    public function propertyLastMonthStatements(Request $request, $id)
    {
        $pmslastmonthpropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthpropertystatements' => $pmslastmonthpropertystatements
        ], 200);
    }

    public function propertyLastNinetyStatements(Request $request, $id)
    {
        $pmslastninetypropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetypropertystatements' => $pmslastninetypropertystatements
        ], 200);
    }    

    public function propertyYearStatements(Request $request, $id)
    {
        $pmsyearpropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyearpropertystatements' => $pmsyearpropertystatements
        ], 200);
    }

     public function propertyQuarterStatements(Request $request, $id)
    {
        $pmsquarterpropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquarterpropertystatements' => $pmsquarterpropertystatements
        ], 200);
    }

     public function propertyLastYearStatements(Request $request, $id)
    {
        $pmslastyearpropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyearpropertystatements' => $pmslastyearpropertystatements
        ], 200);
    }

    public function propertyAllStatements(Request $request, $id)
    {
        $pmsallpropertystatements = PmsStatement::with('tenant','property')->where('pms_property_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsallpropertystatements' => $pmsallpropertystatements
        ], 200);
    } 

    public function tenantStatements(Request $request, $id)
    {
        $pmstenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmstenantstatements' => $pmstenantstatements
        ], 200);
    }

    public function tenantLastMonthStatements(Request $request, $id)
    {
        $pmslastmonthtenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthtenantstatements' => $pmslastmonthtenantstatements
        ], 200);
    } 

    public function tenantLastNinetyStatements(Request $request, $id)
    {
        $pmslastninetytenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetytenantstatements' => $pmslastninetytenantstatements
        ], 200);
    } 

    public function tenantYearStatements(Request $request, $id)
    {
        $pmsyeartenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyeartenantstatements' => $pmsyeartenantstatements
        ], 200);
    }

    public function tenantQuarterStatements(Request $request, $id)
    {
        $pmsquartertenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquartertenantstatements' => $pmsquartertenantstatements
        ], 200);
    } 

    public function tenantLastYearStatements(Request $request, $id)
    {
        $pmslastyeartenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyeartenantstatements' => $pmslastyeartenantstatements
        ], 200);
    } 

    public function tenantAllStatements(Request $request, $id)
    {
        $pmsalltenantstatements = PmsStatement::with('tenant','property')->where('pms_tenant_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsalltenantstatements' => $pmsalltenantstatements
        ], 200);
    } 

}