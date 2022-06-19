<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\ApiMessages;

class LoginJwtController extends Controller
{
    public function login(Request $request){

        $credentials = $request->all(['email', 'password']);

        if(!$token = auth('api')->attempt($credentials)){
            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(){
        auth('api')->logout();

        return response()->json(['message' => 'Logout successfully!!'], 200);
    }

    public function refresh(){
        $token = auth('api')->refresh();

        return response()->json([
            'token' => $token
        ]);
    }
}