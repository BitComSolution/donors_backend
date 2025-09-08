<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\Aist;
use App\Jobs\MS;
use App\Models\Analysis;
use App\Models\Osmotr;
use App\Models\Otvod;
use App\Models\Personas;
use App\Models\Source;
use App\Services\MSService;
use App\Services\SourceService;
use Carbon\Carbon;
use http\Client;
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
        $list = Personas::query();
        foreach ($request->get('filters', []) as $field => $filter) {
            $list = $list->where($field, "LIKE", "%" . $filter . "%");
        }
        $list = $list->paginate($request->get('per_page', 50))->through(function ($value) {
            $value['otvod'] = Otvod::where('card_id', $value['card_id'])->count();
            $value['source'] = Source::where('card_id', $value['card_id'])->count();
            $value['analysis'] = Analysis::where('num', $value['card_id'])->count();
            $value['osmotr'] = Osmotr::where('card_id', $value['card_id'])->count();
            return $value;
        });
        return response()->json($list);
    }

    public function getItem($id)
    {
        $data = Personas::where('card_id', $id)->first();
        $data['source'] = Source::where('card_id', $id)->get();
        $data['otvod'] = Otvod::where('card_id', $id)->get();
        $data['analysis'] = Analysis::where('num', $id)->get();
        $data['osmotr'] = Osmotr::where('card_id', $id)->get();
        return response()->json($data);
    }

    public function sendRequest(Request $request)// id
    {
        //debug
//        $MSService = new MSService;
//        $MSService->send($request->get('ids',[]));
        MS::dispatch($request->get('ids', []));
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

    public function status(Request $request)
    {
        return true;
    }
}
