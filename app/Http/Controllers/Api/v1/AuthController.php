<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(["error" => "The provided credentials are incorrect"], 401);
        }

        return response()->json(["token" => $user->createToken($user->name)->plainTextToken]);
    }

    public function registration(LoginRequest $request)
    {
        $data = $request->all();
        $data['name'] = 'Admin';
        $data['password'] = Hash::make($request['password']);

        $user = User::create($data);
        return response()->json(['message' => $user], 201);
    }
}
