<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduledRequest;
use App\Models\Scheduled;
use App\Services\SourceService;
use Illuminate\Http\Request;

class ScheduledController extends Controller
{
    public function get()
    {
        $list = Scheduled::all();
        $list[] = ["title" => "parser",
            "last_start" => "2025-09-02 12:51:02",
            "period_hours" => 1,
            "created_at" => "2025-09-02T12:51:17.000000Z",
            "updated_at" => "2025-09-02T12:51:17.000000Z",
            "run" => SourceService::getStatus()];
        return response()->json($list);
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
