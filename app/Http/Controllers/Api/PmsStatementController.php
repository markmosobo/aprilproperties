<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsStatement;
use App\Models\PmsTenant;
use App\Models\PmsUnit;
use App\Models\Invoice;
use App\Models\Landlord;
use App\Models\WhatsappReceipt;
use App\Models\EmailReceipt;
use App\Models\WhatsappReminder;
use App\Models\EmailReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class PmsStatementController extends Controller
{
    public function store(Request $request)
    {
        // Get start of the current month and format the date
        $startOfMonth = Carbon::now()->startOfMonth();
        $formattedDate = $startOfMonth->format('M Y');
        
        // Get the current date and format it for reference number
        $orgDate = now();
        $newDate = $orgDate->format('YmdHis'); // Using Carbon formatting
        $refno = "INV" . $newDate . " " . $request->unit_number; // Proper string concatenation
        
        // Determine the payment status based on balance
        $payStatus = $request->balance <= 0 ? 1 : 0; // Ternary operator for cleaner code

        // Create the PmsStatement
        $pmsstatement = PmsStatement::create([
            'ref_no' => $refno,
            'pms_property_id' => $request->pms_property_id,
            'pms_tenant_id' => $request->pms_tenant_id,
            'pms_unit_id' => $request->pms_unit_id,
            'details' => 'Rent + Deposit ' . $request->unit_number . ' - ' . $formattedDate, // Proper string concatenation
            'total' => $request->total,
            'paid' => $request->paid,
            'balance' => $request->balance,
            'status' => $payStatus, // Status for rented unit
            'payment_method' => $request->payment_method,
            'water_bill' => 0,
            'deposit' => $request->deposit
        ]);

        // Return a JSON response
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

    public function editStatement(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);

        if ($pmsstatement) {
                $pmsstatement->update([
                    'total' => $request->total,
                    'paid' => $request->paid,
                    'balance' => $request->balance,
                    'water_bill' => $request->water_bill,
                ]);                   
                

            return response()->json([
                'status' => true,
                'message' => "Statement Updated successfully!",
                'statement' => $pmsstatement
            ], 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);
        if($pmsstatement){
        $pmsstatement->delete();

        return response()->json([
            'status' => true,
            'message' => "Invoice Deleted successfully!",
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
                'water_bill' => $request->water_bill,                  
                'electricity_bill' => $request->electricity_bill                  
            ]);

            $pmsstatement->update([
                'water_bill' => $request->water_bill,
                'electricity_bill' => $request->electricity_bill,
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
        // Assuming $month is like 'September 2024'
        $month = Carbon::now()->format('F Y');

        // Query to filter by the 'rent_month' field in "September 2024" format
        $pmspropertystatements = PmsStatement::with('tenant', 'property', 'unit')
            ->where('pms_property_id', $id)
            ->where('rent_month', $month) // Correlate directly to rent_month column
            ->get();
        $pmspropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
        ->where('rent_month', $month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmspropertystatements' => $pmspropertystatements,
            'pmspropertyrentingstatements' => $pmspropertyrentingstatements
        ], 200);
    }

    public function propertyLastMonthStatements(Request $request, $id)
    {
        // Get last month in the format 'F Y' (e.g., 'August 2024')
        $lastMonth = Carbon::now()->subMonth()->format('F Y');

        // Query to filter by the 'rent_month' field for last month
        $pmslastmonthpropertystatements = PmsStatement::with('tenant', 'property', 'unit')
            ->where('pms_property_id', $id)
            ->where('rent_month', $lastMonth) // Correlate directly to rent_month column for last month
            ->get();
        $pmslastmonthpropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
        ->where('rent_month',
        $lastMonth)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthpropertystatements' => $pmslastmonthpropertystatements,
            'pmslastmonthpropertyrentingstatements' => $pmslastmonthpropertyrentingstatements,
        ], 200);
    }

    public function propertyLastNinetyStatements(Request $request, $id)
    {
        $pmslastninetypropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();
        $pmslastninetypropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
        ->whereBetween('created_at',
        [Carbon::now()->subDays(89)->startOfDay(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastninetypropertystatements' => $pmslastninetypropertystatements,
            'pmslastninetypropertyrentingstatements' => $pmslastninetypropertyrentingstatements,
        ], 200);
    }    

    public function propertyYearStatements(Request $request, $id)
    {
        $pmsyearpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
        $pmsyearpropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
       ->whereBetween('created_at',
        [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyearpropertystatements' => $pmsyearpropertystatements,
            'pmsyearpropertyrentingstatements' => $pmsyearpropertyrentingstatements,
        ], 200);
    }

     public function propertyQuarterStatements(Request $request, $id)
    {
        $pmsquarterpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();
        $pmsquarterpropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
       ->whereBetween('created_at',
        [Carbon::now()->startOfQuarter(), Carbon::now()->endOfDay()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsquarterpropertystatements' => $pmsquarterpropertystatements,
            'pmsquarterpropertyrentingstatements' => $pmsquarterpropertyrentingstatements,
        ], 200);
    }

     public function propertyLastYearStatements(Request $request, $id)
    {
        $pmslastyearpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();
        $pmslastyearpropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)
        ->whereBetween('created_at',
        [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastyearpropertystatements' => $pmslastyearpropertystatements,
            'pmslastyearpropertyrentingstatements' => $pmslastyearpropertyrentingstatements,
        ], 200);
    }

    public function propertyAllStatements(Request $request, $id)
    {
        $pmsallpropertystatements = PmsStatement::with('tenant','property','unit')->where('pms_property_id', $id)->get();
        $pmsallpropertyrentingstatements = PmsStatement::with('tenant','property','unit')
        ->where('pms_tenant_id', '!=', null)
        ->where('pms_property_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsallpropertystatements' => $pmsallpropertystatements,
            'pmsallpropertyrentingstatements' => $pmsallpropertyrentingstatements,
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
        // Get last month in the format 'F Y' (e.g., 'August 2024')
        $lastMonth = Carbon::now()->subMonth()->format('F Y');

        $pmslastmonthtenantstatement = PmsStatement::with('tenant', 'property', 'unit')
        ->where('pms_tenant_id', $id)
        ->latest() // orders by created_at by default
        ->first(); // gets the most recent record


        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmslastmonthtenantstatement' => $pmslastmonthtenantstatement
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
            $lastMonthStatement->prev_arrears = 0;
            $lastMonthStatement->overpayment = 0;
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

    public function generateMonthlyStatements()
    {
        try {
            // Execute the artisan command
            Artisan::call('generate:monthly-statements');

            // Optionally, you can return a response to indicate success
            return response()->json(['message' => 'Monthly statements generated successfully']);

        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => 'Failed to generate monthly statements'], 500);
        }
    }

    //create invoice public function
    // public function createInvoice(Request $request)
    // {
    //     $tenant = PmsTenant::findOrFail($request->pms_tenant_id);
    //     $unit = PmsUnit::findOrFail($tenant->pms_unit_id);
    //     $waterBill = $request->water_bill;


    //     $formattedDate = $request->rentMonth;
    //     $tenantUnit = $tenant->unit_number;
    //     $unitId = $tenant->pms_unit_id;
    //     $orgDate = now();
    //     $date = str_replace('-"', '/', $orgDate);
    //     $newDate = date("YmdHis", strtotime($date));
    //     $monthlyTotal = $tenant->unit->monthly_rent + $tenant->unit->garbage_fee + $tenant->unit->security_fee;
    //     // $refno = "INV".$newDate." ".$tenant->unit->unit_number." Rent @".$monthlyTotal;
    //     $refno = "INV" . $newDate . $tenant->id;

    //     $data = [
    //         'ref_no' => $refno,
    //         'pms_property_id' => $tenant->pms_property_id,
    //         'pms_tenant_id' => $tenant->id,
    //         'pms_unit_id' => $unitId,
    //         'unit_number' => $tenant->unit->unit_number,
    //         'details' => "Rent-" . $tenant->unit->unit_number . "-" . $formattedDate,
    //         'rent_month' => $request->rentMonth,
    //         'status' => 0, // status for rented units
    //         'total' => $monthlyTotal, // You can set the default total
    //         'paid' => 0, // You can set the default paid amount
    //         'balance' => 0, // You can set the default balance
    //     ];

    //     // if (!is_null($waterBill)) {
    //     //     $data['water_bill'] = $waterBill;
    //     // }

    //     // if (is_null($waterBill)) {
    //     //     $data['water_bill'] = 0;
    //     // }

    //     PmsStatement::create($data);

    //     return response()->json([
    //         'status' => true,
    //         'message' => "Retrieved",
    //         'tenant' => $tenant,
    //         'unit' => $unit
    //     ], 200);
    // }
    public function createInvoice(Request $request)
    {
        $tenant = PmsTenant::findOrFail($request->pms_tenant_id);
        $unit = PmsUnit::findOrFail($tenant->pms_unit_id);
        $waterBill = $request->water_bill;

        $formattedDate = $request->rentMonth;
        $tenantUnit = $tenant->unit_number;
        $unitId = $tenant->pms_unit_id;
        $orgDate = now();
        $date = str_replace('-"', '/', $orgDate);
        $newDate = date("YmdHis", strtotime($date));
        $prevArrears = $request->prev_arrears;
        $overPayment = $request->overpayment;
        $monthlyTotal = $tenant->unit->monthly_rent + $tenant->unit->garbage_fee + $tenant->unit->security_fee + $overPayment + $prevArrears;
        $refno = "INV" . $newDate . $tenant->id;

        // Debug: Print variables to check data
        error_log('Checking for duplicate entry');
        error_log('Tenant ID: ' . $tenant->id);
        error_log('Unit ID: ' . $unitId);
        error_log('Rent Month: ' . $formattedDate);

        // Check if an entry with the same tenant ID, unit ID, and rent month already exists
        $existingEntry = PmsStatement::where('pms_tenant_id', $tenant->id)
            ->where('pms_unit_id', $unitId)
            ->where('rent_month', $formattedDate)
            ->first();

        if ($existingEntry) {
            error_log('Duplicate entry found');
            return response()->json([
                'status' => false,
                'message' => "An invoice for this tenant and rent month already exists.",
            ], 409); // 409 Conflict
        }

        $data = [
            'ref_no' => $refno,
            'pms_property_id' => $tenant->pms_property_id,
            'pms_tenant_id' => $tenant->id,
            'pms_unit_id' => $unitId,
            'unit_number' => $tenant->unit->unit_number,
            'details' => "Rent-" . $tenant->unit->unit_number . "-" . $formattedDate,
            'rent_month' => $request->rentMonth,
            'status' => 0, // status for rented units
            'total' => $monthlyTotal, // You can set the default total
            'paid' => 0, // You can set the default paid amount
            'balance' => 0, // You can set the default balance
        ];

        PmsStatement::create($data);

        return response()->json([
            'status' => true,
            'message' => "Invoice created successfully.",
            'tenant' => $tenant,
            'data' => $data,
        ], 200);
    }

    public function updateEmailCount(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:pms_statements,id',
        ]);

        // Find the statement by ID and increment the email_count
        $statement = PmsStatement::find($request->id);
        $statement->increment('email_count');

        //save message
        $emailreminder = EmailReminder::create([
            'statement_id' => $request->id,
            'pms_tenant_id' => $request->tenantId,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $emailreminder->save();

        return response()->json(['message' => 'Email count updated successfully']);
    }

     public function updateWhatsappCount(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:pms_statements,id',
        ]);

        // Find the statement by ID and increment the email_count
        $statement = PmsStatement::find($request->id);
        $statement->increment('whatsapp_count');

        //save message
        $whatsappreminder = WhatsappReminder::create([
            'statement_id' => $request->id,
            'pms_tenant_id' => $request->tenantId,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $whatsappreminder->save();

        return response()->json(['message' => 'Whatsapp count updated successfully']);
    }

     public function updateSmsCount(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:pms_statements,id',
        ]);

        // Find the statement by ID and increment the email_count
        $statement = PmsStatement::find($request->id);
        $statement->increment('sms_count');

        return response()->json(['message' => 'SMS count updated successfully']);
    }

    public function updateEmailReceiptCount(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:pms_statements,id',
        ]);

        // Find the statement by ID and increment the email_count
        $statement = PmsStatement::find($request->id);
        $statement->increment('email_receipt_count');

        //save message
        $emailreceipt = EmailReceipt::create([
            'statement_id' => $request->id,
            'pms_tenant_id' => $request->tenantId,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $emailreceipt->save();

        return response()->json(['message' => 'Email receipt count updated successfully']);
    }

    public function updateWhatsappReceiptCount(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|integer|exists:pms_statements,id',
        ]);

        // Find the statement by ID and increment the email_count
        $statement = PmsStatement::find($request->id);
        $statement->increment('whatsapp_receipt_count');

        //save message
        $whatsappreceipt = WhatsappReceipt::create([
            'statement_id' => $request->id,
            'pms_tenant_id' => $request->tenantId,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $whatsappreceipt->save();

        return response()->json([
            'message' => 'Whatsapp receipt count updated successfully',
            'data' => $whatsappreceipt
        ]);
    }




}