<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsTenant;
use App\Models\PmsUnit;

class PmsTenantController extends Controller
{
    public function store(Request $request)
    {
        $tenant = PmsTenant::create(
        [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'id_number' => $request->id_number,
            'phone_number' => $request->phone_number,
            'pms_property_id' => $request->pms_property_id,
            'pms_unit_id' => $request->pms_unit_id,
        ]);

        $unit=PmsUnit::findOrFail($request->pms_unit_id);
        if($unit){
            $unit->update(array('status' => 1));
            $unit->save();
        }


        return response()->json([
            'status' => true,
            'message' => "Tenant Created successfully!",
            'tenant' => $tenant
        ], 200);        

    }

    public function single(Request $request, $id)
    {
        $tenant = PmsTenant::with('unit','property')->where('id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Unit",
            'tenant' => $tenant
        ], 200);
    } 

    public function update(Request $request,  $id)
    {
        $tenant = PmsTenant::findOrFail($id);
        $tenant->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Tenant Updated successfully!",
            'tenant' => $tenant
        ], 200);
    } 

    public function destroy(Request $request, $id)
    {
        $tenant=PmsTenant::findOrFail($id);
        if($tenant){
        $tenant->delete();

        return response()->json([
            'status' => true,
            'message' => "Tenant Deleted successfully!",
        ], 200);
        }
    } 

    public function vacate(Request $request, $id)
    {
        $tenant=PmsTenant::findOrFail($id);
        if($tenant){
            $tenant->update(array('status' => 0));
            $tenant->save();
        }

        //vacate unit
        $unitId = $tenant->pms_unit_id;
        $unit = PmsUnit::findOrFail($unitId);
        if($unit){
            $unit->update(array('status' => 0));
            $unit->save();
        }

        return response()->json([
            'status' => true,
            'message' => "Tenant Vacated successfully!",
        ], 200);
        
    }           
}
