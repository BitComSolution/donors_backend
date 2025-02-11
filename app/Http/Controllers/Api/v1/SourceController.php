<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\Aist;
use App\Jobs\MS;
use App\Models\Source;
use App\Services\MSService;
use App\Services\SourceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function __construct(
        protected SourceService $sourceService,
        protected MSService     $MSService,)
    {
    }

    public function getListDonors(Request $request)
    {
        $valid = ($request->get('validated', true) == "true") ? 1 : 0;
        $source = Source::where("validated", $valid);
        return response()->json($source->paginate($request->get('per_page', 50)));
    }

    public function getItem(Source $source)
    {
        return response()->json($source);
    }

    public function sendRequest()
    {
        //debug
//        $MSService = new MSService;
//        $MSService->send();
        MS::dispatch();
        return true;
    }

    public function aist(Request $request)
    {
//        $this->sourceService->dbSynchronize();
        $this->sourceService->sendCommand($request->get('startDate', Carbon::now()->subDays(30)->toDateString()), $request->get('endDate', Carbon::now()->toDateString()));
        return true;
    }

    public function ready(Request $request)
    {
        //debug
//        $sourceService = new SourceService;
//        $sourceService->dbSynchronize();
        Aist::dispatch();
        return true;
    }

    public function fail(Request $request)
    {
        $this->sourceService->failLog();
        return true;
    }
}
