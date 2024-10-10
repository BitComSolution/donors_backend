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
        dd($request);
        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
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
