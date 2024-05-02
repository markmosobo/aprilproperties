<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use App\Models\User; 
use Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $apiToken;
    public function __construct()
     {
       $this->apiToken = uniqid(base64_encode(Str::random(40)));
       $this->middleware('auth:api', ['except' => ['login', 'register']]);
     }

    public function login(Request $request){ 
        //User check
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])){ 
          $user = Auth::user(); 
        //Setting login response 
        $success['token'] = $this->apiToken;
        $success['name'] =  $user->name;
          return response()->json([
            'status' => 'success',
            'data' => $success,
            'user'=> $user
          ]); 
        } else { 
          return response()->json([
            'status' => 'error',
            'data' => 'Unauthorized Access'
          ]); 
        } 
    }

    public function register(Request $request) 
    { 
      
      //data validation
      $validator = Validator::make($request->all(), [ 
        'first_name' => 'required', 
        'last_name' => 'required', 
        'email' => 'required|email|unique:users', 
        'password' => 'required', 
        
      ]);
      if ($validator->fails()) { 
        return response()->json(['error'=>$validator->errors()]);
      }
      $postArray = $request->all(); 
     
      $postArray['password'] = bcrypt($postArray['password']); 
      $postArray['role_id'] = 2;
      $postArray['status'] = 2;
      $user = User::create($postArray); 
      
      $success['token'] = $this->apiToken;  
      $success['name'] =  $user->name;
      // send output data to vue3
      return response()->json([
        'status' => 'success',
        'data' => $success,
      ]); 
    }

    public function logout(Request $request) {
        auth()->logout();
        $request->session()->flush();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }
}
