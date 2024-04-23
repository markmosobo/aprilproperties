<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json([
            'status' => true,
            'message' => "Profile Updated successfully!",
            'user' => $user
        ], 200);
    }

    public function changePassword(Request $request, $id)
    {
        {
            $user = User::findOrFail($id);

            if($user){
                $user->update(array('password' => Hash::make($request->new_password)));
                $user->save();
            }
            return response()->json([
                'status' => 200,
                'message' => 'Password changed successfully'
            ]);
        }
    }

   public function resetPassword(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        // Update the user's password
        $user->password = Hash::make('aprilproperties');
        $user->save();

        // Return a success response
        return response()->json([
            'status' => 200,
            'message' => 'Password reset successfully',
        ]);
    }

}
