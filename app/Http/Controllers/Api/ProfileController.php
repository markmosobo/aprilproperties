<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;

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

   public function resetPassword(Request $request) {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User not found',
            ], 404);
        }

        // Generate a random password
        $newPassword = Str::random(10); // Generates a 10-character random password

        // Update the user's password
        $user->password = Hash::make($newPassword); // Hash the new password
        $user->save();

        // Retrieve the email details
        $email = $user->email;
        $subject = 'Password Reset';
        $message = "Use the following password to login: $newPassword";

        // Send the email with the new password
        Mail::to($email)->send(new ResetPasswordMail($subject, $message));

        // Return a success response
        return response()->json([
            'status' => 200,
            'message' => 'Password reset successfully, an email has been sent with the new password.',
        ]);
    }

   

}
