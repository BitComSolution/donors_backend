<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use App\Models\DB;
use App\Models\Logs;
use App\Models\MS\DonationTypes;
use App\Models\Osmotr;
use App\Models\Otvod;
use App\Models\Personas;
use App\Models\Source;
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

    public function switchDB(DB $db)
    {
        Source::truncate();
        Otvod::truncate();
        Analysis::truncate();
        Osmotr::truncate();
        Personas::truncate();
        Db::query()->update(['active' => false]);
        $db->active = true;
        $db->save();
    }
}
