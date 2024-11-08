<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BloodData;
use App\Models\Source;
use App\Services\SourceService;
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

    public function aist()
    {
        $this->sourceService->dbSynchronize();
//        $this->sourceService->sendCommand();
        return true;
    }

    public function ready()
    {
        $this->sourceService->dbSynchronize();

        return true;
    }
}
