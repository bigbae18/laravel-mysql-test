<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request) {
        try {

            $credentials = $request->input();
            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Something went wrong with credentials',
                    'error' => $validator->errors()
                ],400);
            }

            $user_query = "SELECT id, email, password FROM users WHERE email=:email LIMIT 1";
            $query = DB::select($user_query, ['email' => $credentials['email']]);
            $user = $query["0"];
            $password_hashed = Hash::check($credentials['password'], $user->password);

            if ($user == null) {
                return response()->json([
                    "message" => "Something went wrong",
                    "error" => "User doesn't exist"
                ], 400);
            } elseif (!$password_hashed) {
                return response()->json([
                    "message" => "Something went wrong",
                    "error" => "Password doesn't match"
                ], 400);
            } else {
                $id = $user->id;
                Auth::loginUsingId($id);
                return response()->json([
                    'user' => Auth::user(),
                    'logged_in' => Auth::check()
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
