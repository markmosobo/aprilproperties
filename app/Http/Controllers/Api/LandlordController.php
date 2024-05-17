<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Landlord;

class LandlordController extends Controller
{
    public function store(Request $request)
    {
        $landlord = Landlord::create([
            'first_name' =>$request->first_name,
            'last_name' =>$request->last_name,
            'email' =>$request->email,
            'phone_no' =>$request->phone_no,
            'address' =>$request->address,
            'id_number' =>$request->id_number,
            'commission' =>$request->commission,
            'fixed_commission' =>$request->fixed_commission,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Landlord Created successfully!",
            'landlord' => $landlord
        ], 200);
    }

    public function update(Request $request,  $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Landlord Updated successfully!",
            'landlord' => $landlord
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->delete();

        return response()->json([
            'status' => true,
            'message' => "Landlord Deleted successfully!",
        ], 200);
    }

    public function single(Request $request, $id)
    {
        $landlord = Landlord::where('id',$id)->first();

        return response()->json([
            'status' => true,
            'message' => "retreived",
            'landlord' => $landlord
        ], 200);
    }
    
}
