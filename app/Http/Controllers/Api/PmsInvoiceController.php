<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PmsTenant;
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
}
