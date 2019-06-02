<?php

namespace App\Http\Controllers\Api\Identity;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\Identity\CreateIdentityRequest;
use App\Http\Requests\Api\Identity\UpdateIdentityRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\Identity;
use Illuminate\Http\Request;
use Response;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //顯示全部

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

    }
}
