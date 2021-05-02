<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|max:20|min:3',
        ];
        if ($request->has('is_google') && $request->input('is_google') == 1){
            $rules['email'] =  'required';
        }else{
            $rules['password'] = 'required|confirmed|min:8';
            $rules['email'] = 'required|max:30|email';
        }
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors(), 'success' => 0],422);
        }

        $user = User::updateOrcreate($request->only('email'),$request->only('name','email','password'));
        $token = $user->createToken('my_app')->accessToken;
        $user_data = UserResource::make($user);
        return response()->json(['user' => $user_data, 'token' => $token ,'message' => 'User added successfully!' , 'success' => 1],200);

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors(), 'success' => 0],422);
        }
        $creds = $request->only('email','password');
        if (Auth::attempt($creds)){
            $user = Auth::user();
            $token = $user->createToken('my_app')->accessToken;
            $user_data = UserResource::make($user);
            return response()->json(['user' => $user_data, 'token' => $token, 'success' => 1],200);
        }else{
            return response()->json(['error_message'=>'Credentials do not match our records!'], 401);
        }
    }

    public function logout()
    {
        \request()->user()->token()->revoke();
        return response()->json(['message'=>'Successfully logged out'], 200);
    }
}
