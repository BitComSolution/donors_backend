<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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
        //добавить переключатель по валидации
        return response()->json(Source::paginate($request->get('per_page', 50)));
    }

    public function getItem(Source $source)
    {
        return response()->json($source);
    }

    public function sendRequest()
    {
        $this->sourceService->requestMS();
        return BloodData::all();
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
