<?php

namespace App\Http\Controllers\Api\Interest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\Interest\CreateInterestRequest;
use App\Http\Requests\Api\Interest\UpdateInterestRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\Interest;
use Illuminate\Http\Request;
use Response;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //顯示全部
        $interest = Interest::withTrashed()->fromRequest($request);
        $paginator = $interest->paginate(10)->appends($request->all());
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Interest\CreateInterestRequest $request  驗證的資料格式
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInterestRequest $request)
    {
        //新增資料
        Log::record('Interest', 'create', json_encode(['data' => $request->all()]));
        $interest = Interest::create($request->all());
        $interest->save();
        return Response::json($interest, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Interest  $interest 呼叫interest的Model
     * @return \Illuminate\Http\Response
     */
    public function show(Interest $interest)
    {
        // 單筆顯示
        return Response::json($interest, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Interest\UpdateInterestRequest  $request
     * @param  \App\Model\Eloquent\Interest  $interest 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInterestRequest $request, Interest $interest)
    {
        //修改資料
        Log::record('Interest', 'update', json_encode(['data' => $request->all()]));
        $interest->fill($request->all());
        if ($interest->isDirty())
            $interest->save();
        else
            $interest->touch();
        return Response::json($interest, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function delete(Interest $interest)
    {
        //對資料執行軟刪除
        Log::record('Interest', 'delete', json_encode(['data' => $interest->toArray()]));
        $interest->delete();
        return Response::json($interest, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function restore(Interest $interest)
    {
        //將軟刪除的資料恢復
        Log::record('Interest', 'restore', json_encode(['data' => $interest->toArray()]));
        $interest->restore();
        return Response::json($interest, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interest $interest)
    {
        //刪除資料
        Log::record('Interest', 'destroy', json_encode(['data' => $interest->toArray()]));
        $interest->forceDelete();
        return Response::json(null, 200);
    }
}
