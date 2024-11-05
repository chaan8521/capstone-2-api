<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try
        {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',  // Ensure a secure password
                'type' => 'required|string|max:255',
                'status' => 'required|string|max:255',
            ]);
    
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'error' => $validateUser->errors()
                ], status: 401);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),  // Hash the password
                'type' => $request->type,
                'status' => $request->status,
                'department_id' => $request->department_id,
            ]);
    
            // Return success response with a token
            return response()->json([
                'status' => true,
                'message' => 'User Created successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], status: 500);
        }
      
    }

}
