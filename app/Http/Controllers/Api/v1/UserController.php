<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function create(LoginRequest $request)
    {
        $data = $request->all();
        $data['name'] = $request->get('name', 'Test name');
        $data['password'] = Hash::make($request['password']);

        $user = User::create($data);
        return response()->json(['message' => $user], 201);
    }

    public function getList()
    {
        $user = User::all();
        return response()->json($user);
    }

    public function delete(Request $request)
    {

        $user = User::whereIn('id', $request['ids'])->delete();
        return response()->json(['message' => $user], 200);
    }

    public function edit(User $user, Request $request)
    {
        $data = $request->all();
        if (isset($request['password']))
            $data['password'] = Hash::make($request['password']);
        $user = $user->update($data);
        return response()->json($user);
    }
}
