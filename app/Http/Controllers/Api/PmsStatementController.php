<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsStatement;
use App\Models\Invoice;
use App\Models\Landlord;
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
            if($request->balance <= 0)
            {
                $payStatus = 1;
            }
            else
            {
                $payStatus = 0;
            }
            $pmsstatement = PmsStatement::create([
                'ref_no' => $refno,
                'pms_property_id' => $request->pms_property_id,
                'pms_tenant_id' => $request->pms_tenant_id,
                'pms_unit_id' => $request->pms_unit_id,
                'details' => "Rent+Deposit - ".$request->unit_number."-".$formattedDate,
                'total' => $request->total,
                'paid' => $request->paid,
                'balance' => $request->balance,
                'status' => $payStatus, //status for rented unit
                'payment_method' => $request->payment_method,  
                'water_bill' => 0              
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
            if($request->balance <= 0)
            {
                $pmsstatement->update([
                    'total' => $request->total,
                    'paid' => $request->paid,
                    'balance' => $request->balance,
                    'status' => 1,
                ]);                
            }
            else
            {
                $pmsstatement->update([
                    'total' => $request->total,
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

    public function settle(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);

        if ($pmsstatement) {
            if($request->balance <= 0)
            {
                $pmsstatement->update([
                    'paid' => $request->paid,
                    'balance' => $request->balance,
                    'paid_at' => $request->paid_at,
                    'status' => 1,
                ]);  
                //update status on invoice
                $invoice = Invoice::where('statement_id', $id)->first();
                if($invoice)
                {
                    $invoice->update([
                    'status' => 1, //means statement settled
                    ]);
                }              
            }
            else
            {
                $pmsstatement->update([
                    'paid' => $request->paid,
                    'paid_at' => $request->paid_at,
                    'balance' => $request->balance,
                    'status' => 0,
                ]);
            }    
                

            return response()->json([
                'status' => true,
                'message' => "Statement Settled successfully!",
                'statement' => $pmsstatement
            ], 200);
        }
    } 

    public function invoice(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);

        if ($pmsstatement) {

            //create invoice
            Invoice::create([
                'statement_id' => $pmsstatement->id,
                'ref_no' => $pmsstatement->ref_no,
                'pms_property_id' => $pmsstatement->pms_property_id,
                'pms_tenant_id' => $pmsstatement->pms_tenant_id,
                'pms_unit_id' => $pmsstatement->pms_unit_id,
                'details' => "Rent+Deposit - ".$pmsstatement->details,
                'total' => $pmsstatement->total,
                'status' => 0, //status 0 for not settled 1 for settled
                'water_bill' => $request->water_bill                  
            ]);

            $pmsstatement->update([
                'water_bill' => $request->water_bill,
                'total' => $request->water_bill + $pmsstatement->total,
                'status' => 0,
            ]);
                

            return response()->json([
                'status' => true,
                'message' => "Statement Invoiced successfully!",
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
        $pmspropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereMonth('created_at', Carbon::now()->month)->get();
        $pmspropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
        ->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmspropertystatements' => $pmspropertystatements,
            'pmspropertyrentingstatements' => $pmspropertyrentingstatements
        ], 200);
    }

    public function propertyLastMonthStatements(Request $request, $id)
    {
        $pmslastmonthpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthpropertystatements' => $pmslastmonthpropertystatements
        ], 200);
    }

    public function propertyLastNinetyStatements(Request $request, $id)
    {
        $pmslastninetypropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetypropertystatements' => $pmslastninetypropertystatements
        ], 200);
    }    

    public function propertyYearStatements(Request $request, $id)
    {
        $pmsyearpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyearpropertystatements' => $pmsyearpropertystatements
        ], 200);
    }

     public function propertyQuarterStatements(Request $request, $id)
    {
        $pmsquarterpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquarterpropertystatements' => $pmsquarterpropertystatements
        ], 200);
    }

     public function propertyLastYearStatements(Request $request, $id)
    {
        $pmslastyearpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyearpropertystatements' => $pmslastyearpropertystatements
        ], 200);
    }

    public function propertyAllStatements(Request $request, $id)
    {
        $pmsallpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsallpropertystatements' => $pmsallpropertystatements
        ], 200);
    } 

    public function tenantStatements(Request $request, $id)
    {
        $pmstenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmstenantstatements' => $pmstenantstatements
        ], 200);
    }

    public function tenantLastMonthStatements(Request $request, $id)
    {
        $pmslastmonthtenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthtenantstatements' => $pmslastmonthtenantstatements
        ], 200);
    } 

    public function tenantLastNinetyStatements(Request $request, $id)
    {
        $pmslastninetytenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetytenantstatements' => $pmslastninetytenantstatements
        ], 200);
    } 

    public function tenantYearStatements(Request $request, $id)
    {
        $pmsyeartenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyeartenantstatements' => $pmsyeartenantstatements
        ], 200);
    }

    public function tenantQuarterStatements(Request $request, $id)
    {
        $pmsquartertenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquartertenantstatements' => $pmsquartertenantstatements
        ], 200);
    } 

    public function tenantLastYearStatements(Request $request, $id)
    {
        $pmslastyeartenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyeartenantstatements' => $pmslastyeartenantstatements
        ], 200);
    } 

    public function tenantAllStatements(Request $request, $id)
    {
        $pmsalltenantstatements = PmsStatement::with('tenant','property','unit')->where('pms_tenant_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsalltenantstatements' => $pmsalltenantstatements
        ], 200);
    }

    public function overPayment(Request $request, $id)
    {
        // Get the start and end dates for the last month
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastmonthtenantstatement = PmsStatement::where('pms_tenant_id', $id)
        ->whereBetween('created_at',
        [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'lastmonthtenantstatement' => $lastmonthtenantstatement
        ], 200);
    } 

    public function updateTenantLastMonthStatement(Request $request, $id)
    {
        $lastMonthStatement = PmsStatement::where('pms_tenant_id', $id)->first();

        if($lastMonthStatement){
            $lastMonthStatement->balance = 0;
            $lastMonthStatement->save();
            
            return response()->json([
                'status' => true,
                'message' => "Last month's statement updated successfully!",
                'lastMonthStatement' => $lastMonthStatement
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "No last month statement found for the tenant with ID: $id",
            ], 404);
        }
    }

    public function singleInvoice(Request $request, $id)
    {
        $invoice = Invoice::with('tenant','property','unit')->where('statement_id', $id)->first();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'invoice' => $invoice
        ], 200);
    }

     public function invoiceDate(Request $request, $id)
    {
        $invoice = Invoice::with('tenant','property','unit')->where('statement_id', $id)->first();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'invoice' => $invoice
        ], 200);
    }

   public function landlordStatements(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        
        $pmslandlordstatements = PmsStatement::with('tenant', 'property', 'unit')
            ->whereHas('property.landlord', function ($query) use ($landlord) {
                $query->where('landlord_id', $landlord->id);
            })
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();

        return response()->json([
            'status' => true,
            'message' => "Retrieved",
            'pmslandlordstatements' => $pmslandlordstatements
        ], 200);
    }


}