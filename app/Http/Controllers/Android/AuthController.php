<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use App\User;
use App\Pegawai;

class AuthController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Pegawai::where('userid',auth()->user()->userid)->first();
        return $this->createNewToken($token,$user);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    [
                        'userid' => Str::random(),
                        'password' => bcrypt($request->password)
                    ]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function getUser(){
        $userId = auth()->user()->userid;
        $data = Pegawai::where('userid',$userId)->first();
        return response()->json(['data' => $data, 'code' => 200]);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function createNewToken($token,$user){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'userid' => $user->id_pegawai,
            'tipePegawai' => $user->id_tipepeg,
        ]);
    }
}
