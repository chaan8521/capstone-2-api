<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function index(Request $request){
        $user = User::with('department')->get();
        return response()->json([
            'status' => true,
            'message' => 'Users listed Successfully',
            'data' => $user
        ], status: 200);
    }

    public function getTeachers()
    {
        $teachers=User::Where('type','Teacher')->get();
        return response()->json([
            'status' => true,
            'message' => 'Users listed Successfully',
            'data' => $teachers
        ], status: 200);
    }   
    public function getStudents()
    {
        $students=User::Where('type','Student')->get();
        return response()->json([
            'status' => true,
            'message' => 'Users listed Successfully',
            'data' => $students
        ], status: 200);
    }   

    public function create(Request $request)
    {
        try
        {
            $validateUser = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'department_id' => 'required|int',
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
                'department_id' => $request->department_id,
                'password' => Hash::make($request->name),  // Hash the password
                'type' => $request->type,
                'status' => $request->status,
            ]);
    
            // Return success response with a token
            return response()->json([
                'status' => true,
                'message' => 'User Created successfully',
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], status: 500);
        }
      
    }

    public function update(Request $request, $id){

        $duplicate_user = User::where(
            'email', $request->email
            )->where('id', '!=', $id)
            ->first();

        if($duplicate_user) {
            return response()->json([
                'message' => $request->email .' is already exist',
            ], status: 422);
        }
        
      
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $user
        ], 200);
    
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ], 200);
    }
}
