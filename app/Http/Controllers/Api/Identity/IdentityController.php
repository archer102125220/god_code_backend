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
        $identity = Identity::withTrashed()->fromRequest($request);
        $paginator = $identity->paginate(10)->appends($request->input());
        return Response::json($paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Identity\CreateIdentityRequest $request  驗證的資料格式
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIdentityRequest $request)
    {
        //新增資料
        Log::record('Identity', 'create', json_encode(['data' => $request->all()]));
        $identity = Identity::create($request->all());
        $identity->save();
        return Response::json($identity, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Identity  $identity 呼叫identity的Model
     * @return \Illuminate\Http\Response
     */
    public function show(Identity $identity)
    {
        // 單筆顯示
        return Response::json($identity, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Identity\UpdateIdentityRequest  $request
     * @param  \App\Model\Eloquent\Identity  $identity 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIdentityRequest $request, Identity $identity)
    {
        //修改資料
        Log::record('Identity', 'update', json_encode(['data' => $request->all()]));
        if ($identity->isDirty())
            $identity->save();
        else
            $identity->touch();
        return Response::json($identity, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function delete(Identity $identity)
    {
        //對資料執行軟刪除
        Log::record('Identity', 'delete', json_encode(['data' => $identity->toArray()]));
        $identity->delete();
        return Response::json($identity, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function restore(Identity $identity)
    {
        //將軟刪除的資料恢復
        Log::record('Identity', 'restore', json_encode(['data' => $identity->toArray()]));
        $identity->restore();
        return Response::json($identity, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Identity  $identity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Identity $identity)
    {
        //刪除資料
        Log::record('Identity','destory',json_encode(['data'=>$identity->toArray()]));
        $identity->forceDelete();
        return Response::json(null,200);
    }
}
