<?php

namespace App\Http\Controllers\Api\Log;

use App\Http\Controllers\Controller;
use App\Model\Eloquent\Log;
use Illuminate\Http\Request;
use Response;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $logs = Log::with('creator')->fromRequest($request);
        $paginator = $logs->paginate(20)->appends($request->input());
        return Response::json($paginator, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        return Response::json($log, 200);
    }

}
