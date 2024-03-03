<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PmsYear;

class PmsYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pmsyears = PmsYear::all();
        return response()->json([
            "lists" => [
                'pmsyears' => $pmsyears,
                
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pmsyear = PmsYear::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Pms Year Created successfully!",
            'pmsyear' => $pmsyear
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pmsyear=PmsYear::findOrFail($id);
        if($pmsyear){
            $pmsyear->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Pms Year Updated successfully!",
                'pmsyear' => $pmsyear
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $pmsyear=PmsYear::findOrFail($id);
        if($pmsyear){
        $pmsyear->delete();

        return response()->json([
            'status' => true,
            'message' => "Pms Year Deleted successfully!",
        ], 200);
        }
    }

    public function single(Request $request, $id)
    {
        $pmsyear = PmsYear::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "retrieved",
            'pmsyear' => $pmsyear
        ], 200);
    }    
}
