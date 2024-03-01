<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        try {
            if(Auth::attempt(["email" => $request->email, "password" => $request->password])){
                $user = auth()->user();
                $user->tokens()->delete();
                $accessToken = $user->createToken("auth-token")->plainTextToken;

                return response()->json([
                    "status" => "success",
                    "message" => "Successfully login",
                    "data" => [
                        "access_token" => $accessToken,
                        "id" => $user->id,
                        "name" => $user->name,
                        "email" => $user->email,
                    ]
                ]);
            }else{
                return response()->json([
                    "status" => "fail",
                    "message" => "Invalid credentials"
                ], 400);
            }

        } catch (Exception $er) {
            return response()->json([
                "status" => "error",
                "message" => $er->getMessage()
            ]);
        }
    }
}
