<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$this->checkUserLoggedIn($id)) {
            return response()->redirectToRoute('login');
        }

        try {
            $user_query = "SELECT * FROM users WHERE id = :id";
            $user = DB::select($user_query, ['id' => $id])["0"];

            $user_info_query = "SELECT * FROM users_info WHERE user_id = :id";
            $user_info = DB::select($user_info_query, ['id' => $id]);

            return response()->view('user.show', [
                'user' => $user,
                'user_info' => (!empty($user_info) ? $user_info["0"] : null)
            ], 202);
        } catch (\Exception $e) {
            return response()->view('errors.exceptions', [
                'title' => 'Server Exception',
                'message' => $e->getMessage(),
                'requested_url' => '/'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->checkUserLoggedIn($id)) {
            return response()->redirectToRoute('login');
        }
        
        try {
            $user_query = "SELECT * FROM users WHERE id = :id";
            $user = DB::select($user_query, ['id' => $id])["0"];

            return view('user.edit', ['user' => $user]);

        } catch (\Exception $e) {
            return response()->view('errors.exceptions', [
                'title' => 'Server Exception',
                'message' => $e->getMessage(),
                'requested_url' => '/'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TO-DO UPDATE THE IBAN + DNI + BILLING ADDRESS
    }

    private function checkUserLoggedIn(int $id) {
        if (Auth::id() != $id) {
            return false;
        }
    }
}
