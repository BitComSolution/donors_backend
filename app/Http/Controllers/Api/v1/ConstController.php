<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConstController extends Controller
{
    public function get(Request $request)
    {
        return response()->json(Constant::all());
    }

    public function edit(Constant $const, Request $request)
    {
        return response()->json($const->update($request->all()));
    }
}
