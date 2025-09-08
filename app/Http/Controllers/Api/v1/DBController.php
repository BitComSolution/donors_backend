<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\DB;
use App\Models\Logs;
use App\Models\MS\DonationTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class DBController extends Controller
{
    public function get()
    {
        return response()->json(DB::all());
    }

    public function edit(DB $db, Request $request)
    {
        return response()->json($db->update($request->all()));
    }

    public function create(Request $request)
    {
        $db = DB::firstOrCreate($request->all());
        return response()->json($db);
    }

    public function delete(DB $db)
    {
        return response()->json($db->delete());
    }
}
