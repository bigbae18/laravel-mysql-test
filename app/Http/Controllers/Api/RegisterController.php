<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {
        try {
            $credentials = $request->input();

            $validator = Validator::make($credentials, [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|int',
                'password' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Something went wrong with credentials',
                    'error' => $validator->errors()
                ],400);
            }

            $user_exists_query = "SELECT * FROM users WHERE email = :email";
            $user = DB::select($user_exists_query, [
                'email' => $credentials['email']
            ]);

            if ($user != null) {
                return response()->json([
                    'message' => 'Something went wrong registering',
                    'error' => 'Email already exists'
                ],400);
            } else {
                
                $credentials['password'] = Hash::make($credentials['password']);
                $insert_user_query = "INSERT INTO users (name, surname, email, phone, password) VALUES (:name, :surname, :email, :phone, :password)";
                DB::statement($insert_user_query, [
                    'name' => $credentials['name'],
                    'surname' => $credentials['surname'],
                    'email' => $credentials['email'],
                    'phone' => $credentials['phone'],
                    'password' => $credentials['password'],
                ]);
                return response()->json([
                    'message' => 'Registered successful'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong with server',
                'error' => $e->getMessage()
            ],500);
        }
    }
}
