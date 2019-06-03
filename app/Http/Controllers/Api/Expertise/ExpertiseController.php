<?php

namespace App\Http\Controllers\Api\Expertise;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\Expertise\CreateExpertiseRequest;
use App\Http\Requests\Api\Expertise\UpdateExpertiseRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\Expertise;
use Illuminate\Http\Request;
use Response;

class ExpertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //顯示全部
        $expertise = Expertise::withTrashed()->fromRequest($request);
        $paginator = $expertise->paginate(10)->appends($request->input());
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Interest\CreateExpertiseRequest $request  驗證的資料格式
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExpertiseRequest $request)
    {
        //新增資料
        Log::record('Expertise', 'create', json_encode(['data' => $request->all()]));
        $expertise = Expertise::create($request->all());
        $expertise->save();
        return Response::json($expertise, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Expertise  $expertise 呼叫expertise的Model
     * @return \Illuminate\Http\Response
     */
    public function show(Expertise $expertise)
    {
        // 單筆顯示
        return Response::json($expertise, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Interest\UpdateExpertiseRequest  $request
     * @param  \App\Model\Eloquent\Expertise  $interest 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpertiseRequest $request, Expertise $expertise)
    {
        //修改資料
        Log::record('Expertise', 'update', json_encode(['data' => $request->all()]));
        $expertise = fill($request->all());
        if ($expertise->isDirty())
            $expertise->save();
        else
            $expertise->touch();
        return Response::json($expertise, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function delete(Expertise $expertise)
    {
        //對資料執行軟刪除
        Log::record('Expertise', 'delete', json_encode(['data' => $expertise->toArray()]));
        $expertise->delete();
        return Response::json($expertise, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function restore(Expertise $expertise)
    {
        //將軟刪除的資料恢復
        Log::record('Expertise', 'restore', json_encode(['data' => $expertise->toArray()]));
        $expertise->restore();
        return Response::json($expertise, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Expertise  $expertise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expertise $expertise)
    {
        //刪除資料
        Log::record('Expertise', 'destroy', json_encode(['data' => $expertise->toArray()]));
        $expertise->forceDelete();
        return Response::json(null, 200);
    }
}
