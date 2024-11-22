<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BloodComponentMain;
use App\Models\BloodData;
use App\Models\Source;
use App\Services\SourceService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function __construct(
        protected SourceService $sourceService)
    {
    }

    public function getListDonors(Request $request)
    {
        $source = Source::where("validated", $request->get('validated', true));
        return response()->json($source->paginate($request->get('per_page', 50)));
    }

    public function getItem(Source $source)
    {
        return response()->json($source);
    }

    public function sendRequest()
    {
        $create=BloodComponentMain::create(["number" => 3,
            "BloodNumber" => 5,
            "BloodGroup" => "test",
            "Phenotype" => "test",
            "Count" => 222,
            "RegionReportGuid" => "80A027C9-4A52-4E13-9E98-A1EFFFE80914",
            "OrgId" => 1,
            "OrgName" => "test"]);
        return BloodComponentMain::all();

//        $this->sourceService->requestMS();
//        return BloodData::all();
    }

    public function aist(Request $request)
    {
//        $this->sourceService->dbSynchronize();
        $this->sourceService->sendCommand($request->get('startDate', Carbon::now()->subDays(30)->toDateString()), $request->get('endDate', Carbon::now()->toDateString()));
        return true;
    }

    public function ready(Request $request)
    {
        $this->sourceService->dbSynchronize();
        return true;
    }

    public function fail(Request $request)
    {
        $this->sourceService->failLog();
        return true;
    }
}
