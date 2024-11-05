<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try
        {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required', 
            ]);
    
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validateUser->errors()
                ], status: 401);
            }
            if(!Auth::attempt($request->only(['email','password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Password is Incorrect',
                ], status: 401);
            }
            $user = User::where('email',$request->email)->first();
            return response()->json([
                'status' => true,
                'message' => 'Log In successfully',
                'data' =>$user,
                'token' => $user->createToken("API TOKEN")->plainTextToken,
               
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], status: 500);
        }
    }

    public function profile(){
       $userData = auth()->user();
       return response()->json([
        'status' => true,
        'message' => 'Profile info',
        'data' => $userData,
        'id' => auth()->user()->id
    ], 200);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User Logout',
            'data' => [],
        ], 200);
    }

}
