<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $redirect_url = $request->fullUrl();

        $validator = Validator::make($request->input(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return view('errors.login', [
                'title' => 'There was an error validating credentials',
                'errors' => $validator->errors(),
                'requested_url' => $redirect_url
            ]);
        }
        $credentials = array('email' => $request->input('email'),'password' => $request->input('password'));
        $user_query = "SELECT * FROM users WHERE email = :email";
        $user = DB::select($user_query, ['email' => $credentials["email"]]);
        
        if (empty($user)) {
            return response()->view('errors.auth', [
                'title' => 'There was an error with the authentication',
                'errors' => 'E-mail does not exists',
                'requested_url' => $redirect_url
            ], 400);
        } elseif(!Hash::check($credentials["password"], $user["0"]->password)) {
            return response()->view('errors.auth', [
                'title' => 'There was an error with the authentication',
                'errors' => 'Password does not match',
                'requested_url' => $redirect_url
            ], 400);
        } else {
            Auth::loginUsingId($user["0"]->id);
            return redirect()->route('users.show', ['id' => $user["0"]->id]);
            // TO-DO:
            // Redirect View for logged user.
            // Retrieve data for UserInfo
        }
    }
}
