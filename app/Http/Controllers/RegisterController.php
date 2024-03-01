<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{

            $birth_date = Carbon::createFromFormat('d/m/Y', $request->birth_date);

            $formatted_birth_date = $birth_date->format('Y-m-d');

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "birth_date" => $formatted_birth_date,
                "password" => bcrypt($request->password)
            ]);

            $accessToken = $user->createToken("auth-token")->plainTextToken;

            return response()->json([
                "status" => 'success',
                "message" => 'uccessfully registered',
                "data" => [
                    "access_token" => $accessToken,
                    "id" => $user->id,
                    "name" => $request->name,
                    "email" => $request->email,
                ]
            ]);


        }catch(Exception $er){
            return response()->json([
                "status" => 'error',
                "message" => $er->getMessage()
            ]);
        }

    }
}
