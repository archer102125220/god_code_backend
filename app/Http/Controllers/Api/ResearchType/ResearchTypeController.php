<?php

namespace App\Http\Controllers\Api\ResearchType;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\ResearchType\CreateResearchTypeRequest;
use App\Http\Requests\Api\ResearchType\UpdateResearchTypeRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\ResearchType;
use Illuminate\Http\Request;
use Response;

class ResearchTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //GET，顯示資料(一般是列表)
    public function index(Request $request)
    {
        //withTrashed()強制讓已經被軟刪除的模型資料出現在查詢結果裡面。
        $researchType = ResearchType::withTrashed()->fromRequest($request);
        //paginate()分頁處理，appends()添加所需要的參數到分頁連結中。例如:http://laravel.app?page=2
        $paginator = $researchType->paginate(10)->appends($request->input());
        //噴json格式的分頁結果,成功後跳200代碼(請求成功)
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\ResearchType\CreateResearchTypeRequest $request
     * @return \Illuminate\Http\Response
     */

    //POST，儲存資料
    public function store(CreateResearchTypeRequest $request)
    {
        Log::record('ResearchType', 'create', json_encode(['data' => $request->all()]));
        $researchType = ResearchType::create($request->all());
        $researchType->save();
        return Response::json($researchType, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\ResearchType  $EventType
     * @return \Illuminate\Http\Response
     */

    //GET，顯示某筆資料
    public function show(ResearchType $researchType)
    {
        return Response::json($researchType, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\ResearchType\UpdateResearchTypeRequest  $request
     * @param  \App\Model\Eloquent\ResearchType  $EventType
     * @return \Illuminate\Http\Response
     */

    //PUT/PATCH，更新某筆資料
    public function update(UpdateResearchTypeRequest $request, ResearchType $researchType)
    {
        Log::record('researchType', 'update', json_encode(['data' => $request->all()]));
        //fill()填充屬性陣列
        $researchType->fill($request->all());
        //isDirty()判斷模型是否更改過
        if ($researchType->isDirty()) {
            $researchType->save();
        } else {
            //更新模型的時間戳
            $researchType->touch();
        }
        return Response::json($researchType, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\ResearchType  $EventType
     * @return \Illuminate\Http\Response
     */

    //刪除模型
    public function delete(ResearchType $researchType)
    {
        //toArray()將集合轉換成純 PHP 陣列
        Log::record('ResearchType', 'delete', json_encode(['data' => $researchType->toArray()]));
        $researchType->delete();
        return Response::json($researchType, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\ResearchType  $EventType
     * @return \Illuminate\Http\Response
     */

    //恢復被軟刪除的模型
    public function restore(ResearchType $researchType)
    {
        Log::record('ResearchType', 'restore', json_encode(['data' => $researchType->toArray()]));
        $researchType->restore();
        return Response::json($researchType, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\ResearchType  $EventType
     * @return \Illuminate\Http\Response
     */

    //DELETE，刪除某筆資料
    public function destroy(ResearchType $researchType)
    {
        Log::record('ResearchType', 'destroy', json_encode(['data' => $researchType->toArray()]));
        //forceDelete從模型資料庫刪除
        $researchType->forceDelete();
        return Response::json(null, 200);
    }
}
