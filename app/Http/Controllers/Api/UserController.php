<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'users' => $users
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
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt('aprilproperties'),
        ]);

        return response()->json([
            'status' => true,
            'message' => "User Created successfully!",
            'user' => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "User Updated successfully!",
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => "User Deleted successfully!",
        ], 200);
    }

    public function activate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($user){
            $user->update(array('status' => 1));
            $user->save();
        }
    }

    public function deactivate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($user){
            $user->update(array('status' => 2));
            $user->save();
        }
    }

    public function single(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => "success",
            'user' => $user
        ], 200);
    }
}
