<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogsController extends Controller
{
    public function getList(Request $request)
    {
        return response()->json(Logs::all());
    }

    public function getFile($id)
    {
        $log = Logs::find($id);
        return Storage::download($log['file']);

    }
}
