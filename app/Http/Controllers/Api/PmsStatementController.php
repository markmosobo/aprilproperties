<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsStatement;

class PmsStatementController extends Controller
{
    public function store(Request $request)
    {
            $pmsstatement = PmsStatement::create([
                'ref_no' => $request->ref_no,
                'pms_property_id' => $request->pms_property_id,
                'pms_tenant_id' => $request->pms_tenant_id,
                'details' => $request->details,
                'total' => $request->total,
                'paid' => $request->paid,
                'balance' => $request->balance,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Statement Created successfully!",
                'pmsstatement' => $pmsstatement
            ], 200);
            
    }

    public function update(Request $request, string $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);
        if($pmsstatement){
        $pmsstatement->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "Statement Updated successfully!",
            'statement' => $pmsstatement
        ], 200);
        }
    } 

    public function single(Request $request, $id)
    {
        $pmsstatement = PmsStatement::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'statement' => $pmsstatement
        ], 200);
    }       

}