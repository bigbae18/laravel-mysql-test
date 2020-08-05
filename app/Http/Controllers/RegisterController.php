<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('register.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_url = $request->fullUrl();
        $validator = Validator::make($request->input(), [
                'name' => 'required|string',
                'surname' => 'required|string',
                'email' => 'required|email|string',
                'phone' => 'int|required',
                'password' => 'required|string',
                'repeat_password' => 'required|string|same:password'
            ]);
        if ($validator->fails()) {
            return response()->view('errors.register', [
                'title' => 'There was an error with registering credentials',
                'errors' => $validator->errors(),
                'requested_url' => $request_url
            ]);
        }
        $credentials = array(
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => $request->input('password')
        );
        
        if ($this->checkIfEmailExists($credentials["email"])) {
            return response()->view('errors.auth', [
                'title' => 'There was an error trying to register',
                'errors' => 'The e-mail you trying to register already exists.',
                'requested_url' => $request_url
            ]);
        }
        $credentials["password"] = Hash::make($credentials["password"]);
        $register_query = "INSERT INTO users (name, surname, email, phone, password) VALUES (:name, :surname, :email, :phone, :password)";
        try {
            DB::insert($register_query, [
                'name' => $credentials["name"],
                'surname' => $credentials["surname"],
                'email' => $credentials["email"],
                'phone' => $credentials["phone"],
                'password' => $credentials["password"]
            ]);
            return redirect()->route('home');
        } catch(\Exception $e){
            return response()->view('errors.exceptions', [
                'title' => 'Server Exception',
                'message' => $e->getMessage(),
                'requested_url' => $request_url
            ], 500);
        }
    }
    private function checkIfEmailExists($email) {
        $email_check_sql = "SELECT * FROM users WHERE email = :email";
        $email = DB::select($email_check_sql, ['email' => $email]);
        if (!empty($email)) {
            return true;
        }
        return false;
    }
}
