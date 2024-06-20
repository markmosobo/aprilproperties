<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PmsTenant;
use App\Models\PmsProperty;
use App\Models\PmsStatement;
use Carbon\Carbon;

class PmsInvoiceController extends Controller
{
    public function tenantInvoices(Request $request, $id)
    {
        $tenant = PmsTenant::findOrFail($id);
        $pmstenantinvoices = Invoice::with('tenant','property','unit')->where('pms_tenant_id', $tenant->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmstenantinvoices' => $pmstenantinvoices
        ], 200);
    }

    public function propAwaitingInvoicing(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $propertyawaitinginvoicing = PmsStatement::latest()->where('water_bill', null)->where('status',0)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyawaitinginvoicing' => $propertyawaitinginvoicing
        ], 200);
    }

    public function propInvoicestoSettle(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $propertyinvoicestosettle = PmsStatement::latest()->whereNotNull('water_bill')->where('status',0)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertyinvoicestosettle' => $propertyinvoicestosettle
        ], 200);
    }

    public function propSettledInvoices(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $propertysettledinvoices = PmsStatement::latest()->whereNotNull('water_bill')->where('status',1)->with('tenant','property','unit')->where('pms_property_id', $property->id)->whereMonth('created_at', Carbon::now()->month)->get();

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'propertysettledinvoices' => $propertysettledinvoices
        ], 200);
    }
}
