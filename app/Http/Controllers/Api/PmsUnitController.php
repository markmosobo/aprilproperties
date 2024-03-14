<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsUnit;
use App\Models\PmsProperty;

class PmsUnitController extends Controller
{

    public function store(Request $request, $id)
    {
        $property = PmsProperty::findOrFail($id);
        $property->units()->create(
        [
            'unit_number' => $request->unit_number,
            'pms_property_id' => $property->id,
            'type' => $request->type,
            'deposit' => $request->deposit,
            'monthly_rent' => $request->monthly_rent,
            'garbage_fee' => $request->garbage_fee,
            'security_fee' => $request->security_fee,
            'water_meter' => $request->water_meter,
            'electricity_meter' => $request->electricity_meter
        ]);

    }

    public function units(Request $request, $id)
    {
        $units = PmsUnit::where('pms_property_id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Units",
            'units' => $units
        ], 200);
    }

    public function single(Request $request, $id)
    {
        $unit = PmsUnit::where('id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => "Unit",
            'unit' => $unit
        ], 200);
    } 

    public function update(Request $request,  $id)
    {
        $unit = PmsUnit::findOrFail($id);
        $unit->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Unit Updated successfully!",
            'unit' => $unit
        ], 200);
    } 

    public function vacate(Request $request, $id)
    {
        $unit=PmsUnit::findOrFail($id);
        if($unit){
            $unit->update(array('status' => 0));
            $unit->save();
        }

        return response()->json([
            'status' => true,
            'message' => "Unit Vacated successfully!",
        ], 200);
        
    }   

    public function destroy(Request $request, $id)
    {
        $unit = PmsUnit::findOrFail($id);
        if($unit){
        $unit->delete();

        return response()->json([
            'status' => true,
            'message' => "Unit Deleted successfully!",
        ], 200);
        }
    }           
}
