<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Rules\Iban;
use Validator;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if (!$this->checkUserLoggedIn($id)) {
            return response()->redirectToRoute('login');
        }

        try {
            $user_query = "SELECT * FROM users WHERE id = :id";
            $user = DB::select($user_query, ['id' => $id])["0"];

            $user_info_query = "SELECT * FROM users_info WHERE user_id = :id";
            $user_info = DB::select($user_info_query, ['id' => $id]);

            return response()->view('user.index', [
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
     * Show the form for creating the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (!$this->checkUserLoggedIn($id)) {
            return response()->redirectToRoute('login');
        }
        
        try {
            $user_query = "SELECT * FROM users WHERE id = :id";
            $user = DB::select($user_query, ['id' => $id])["0"];

            return view('user.create', ['user' => $user]);

        } catch (\Exception $e) {
            return response()->view('errors.exceptions', [
                'title' => 'Server Exception',
                'message' => $e->getMessage(),
                'requested_url' => '/'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request_url = route('users.create', ['id' => $id]);
        $input_array = $request->input();
        $input_array["iban"] = str_replace(" ", "", $input_array["iban"]);

        if (!$this->checkUserLoggedIn($id)) {
            return response()->redirectToRoute('login');
        }

        $validator = Validator::make($input_array, [
            'iban' => ['required', 'string', new Iban],
            'identity_document' => 'nullable|string|min:9|max:9',
            'billing_address' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->view('errors.user', [
                'title' => 'There was an error validating your information',
                'errors' => $validator->errors(),
                'requested_url' => $request_url
            ], 400);
        }
        $credentials = array(
            'iban' => $request->input('iban'), 
            'identity_document' => $request->input('identity_document'), 
            'billing_address' => $request->input('billing_address'));

        $insert_query = "INSERT INTO users_info (user_id, iban, identity_document, billing_address) VALUES (:user_id, :iban, :identity_document, :billing_address)";
        if ($this->checkIbanExists($credentials["iban"], $id)) {
            return response()->view('errors.exceptions', [
                'title' => 'There was an error verifying your info',
                'message' => 'IBAN already exists',
                'requested_url' => $request_url
            ]);
        }
        try {
            DB::insert($insert_query, [
                'user_id' => $id,
                'iban' => $credentials["iban"],
                'identity_document' => $credentials["identity_document"],
                'billing_address' => $credentials["billing_address"]
            ]);
            return redirect()->route('users.index', ['id' => $id]);
        } catch(\Exception $e) {
            return response()->view('errors.exceptions', [
                'title' => 'Exception on query',
                'message' => $e->getMessage(),
                'requested_url' => $request_url
            ],500);
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
            $user_info_query = "SELECT * FROM users_info WHERE user_id = :user_id";
            $user_info = DB::select($user_info_query, ['user_id' => $id])["0"];
            return view('user.edit', [
                'user' => $user,
                'user_info' => $user_info
            ]);

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
        $request_url = route('users.index', ['id' => $id]);
        $request_array = $request->input();
        $update_data = array_slice($request_array, 2, 2);
        
        $validator = Validator::make($update_data, [
            'iban' => ['sometimes', 'required', new Iban],
            'identity_document' => 'sometimes|required|string',
            'billing_address' => 'sometimes|required|string'
        ]);
        if ($validator->fails()) {
            response()->view('errors.user', [
                'title' => 'There was an error validating your information',
                'error' => $validator->errors(),
                'requested_url' => $request_url
            ], 400);
        }
        $update_iban_query = "UPDATE users_info SET iban = :iban WHERE user_id = :user_id";
        $update_billingAddress_query = "UPDATE users_info SET billing_address = :billing_address WHERE user_id = :user_id";
        $update_identityDocument_query = "UPDATE users_info SET identity_document = :identity_document WHERE user_id = :user_id";
        try {
            if (array_key_exists('iban', $update_data)) {
                if ($this->checkIbanExists($update_data["iban"], $id)) {
                    DB::update($update_iban_query, [
                        'iban' => $update_data["iban"],
                        'user_id' => $id
                    ]);
                }
            }
            if (array_key_exists('identity_document', $update_data)) {
                DB::update($update_identityDocument_query, [
                    'identity_document' => $update_data["identity_document"],
                    'user_id' => $id
                    ]);
            }
            if (array_key_exists('billing_address', $update_data)) {
                DB::update($update_billingAddress_query, [
                    'billing_address' => $update_data["billing_address"],
                    'user_id' => $id
                    ]);
            }
            return redirect()->route('users.index', ['id' => $id]);
        } catch (\Exception $e) {
            return response()->view('errors.exceptions', [
                'title' => 'Server Exception',
                'message' => $e->getMessage(),
                'requested_url' => '/'
            ], 500);
        }
    }

    private function checkUserLoggedIn(int $id) {
        if (Auth::id() != $id) {
            return false;
        }
        return true;
    }
    private function checkIbanExists(string $iban, int $user_id) {
        $iban_query = "SELECT * FROM users_info WHERE user_id = :user_id OR iban = :iban";
        $data = DB::select($iban_query, [
            'user_id' => $user_id,
            'iban' => $iban
        ]);
        if (!empty($data)) {
            return true;
        }
        return false;
    }
}
