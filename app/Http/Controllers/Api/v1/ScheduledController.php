<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduledRequest;
use App\Models\Scheduled;
use Illuminate\Http\Request;

class ScheduledController extends Controller
{
    public function get()
    {
        return response()->json(Scheduled::all());
    }

    public function edit(Scheduled $scheduled, Request $request)
    {
        return response()->json($scheduled->update($request->all()));
    }

    public function create(ScheduledRequest $request)
    {
        $scheduled = Scheduled::firstOrCreate($request->all());
        return response()->json($scheduled);
    }

    public function delete(Scheduled $scheduled)
    {
        return response()->json($scheduled->delete());
    }
}
