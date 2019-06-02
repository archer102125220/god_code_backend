<?php

namespace App\Http\Controllers\Api\SchoolSystem;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\EventType\CreateSchoolSystemRequest;
use App\Http\Requests\Api\EventType\UpdateSchoolSystemRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\SchoolSystem;
use Illuminate\Http\Request;
use Response;

class SchoolSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //顯示全部
        $schoolSystem = SchoolSystem::withTrashed()->fromRequest($request);
        $paginator = $schoolSystem->paginate(10)->appends($request->input());
        return Response::json($paginator, 200); //Resonse是要回傳的東西
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\SchoolSystem\CreateSchoolSystemRequest $request  驗證的資料格式
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSchoolSystemRequest $request)
    {
        //新增資料
        Log::record('SchoolSystem', 'create', json_encode(['data' => $request->all()]));
        $schoolSystem = SchoolSystem::create($request->all());
        $schoolSystem->save();
        return Response::json($schoolSystem, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\SchoolSystem  $schoolSystem 呼叫schoolSystem的Model
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolSystem $schoolSystem)
    {
        // 單筆顯示
        return Response::json($schoolSystem, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\EventType\UpdateEventTypeRequest  $request
     * @param  \App\Model\Eloquent\SchoolSystem  $schoolSystem 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventTypeRequest $request, SchoolSystem $schoolSystem)
    {
        //修改資料
        Log::record('SchoolSystem', 'update', json_encode(['data' => $request->all()]));
        $schoolSystem->fill($request->all());
        if ($schoolSystem->isDirty())
            $schoolSystem->save();
        else
            $schoolSystem->touch();
        return Respone::json($schoolSystem, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\SchoolSystem  $schoolSystem
     * @return \Illuminate\Http\Response
     */
    public function delete(SchoolSystem $schoolSystem)
    {
        //對資料執行軟刪除
        Log::record('SchoolSystem', 'delete', json_encode(['data' => $schoolSystem->toArray()]));
        $schoolSystem->delete();
        return Response::json($schoolSystem, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\SchoolSystem  $schoolSystem
     * @return \Illuminate\Http\Response
     */
    public function restore(SchoolSystem $schoolSystem)
    {
        //將軟刪除的資料恢復
        Log::record('SchoolSystem', 'restore', json_encode(['data' => $schoolSystem->toArray()]));
        $schoolSystem->restore();
        return Response::json($schoolSystem, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\SchoolSystem  $schoolSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolSystem $schoolSystem)
    {
        //刪除資料
        Log::record('SchoolSystem', 'destory', json_encode(['data'->$schoolSystem->toArry()]));
        $schoolSystem->forceDelete();
        return Response::json(null,200);
    }
}
