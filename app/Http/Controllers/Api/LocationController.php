<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $locations = Location::all();
        return response()->json([
            "lists" => [
                'locations' => $locations,
                
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = Location::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Location Created successfully!",
            'location' => $location
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $location=Location::findOrFail($id);
        if($location){
            $location->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Location Updated successfully!",
                'location' => $location
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $location=Location::findOrFail($id);
        if($location){
        $location->delete();

        return response()->json([
            'status' => true,
            'message' => "Location Deleted successfully!",
        ], 200);
        }
    }

    public function single(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "retreived",
            'location' => $location
        ], 200);
    }
}
