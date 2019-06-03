<?php

namespace App\Http\Controllers\Api\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\Organizer\CreateOrganizerRequest;
use App\Http\Requests\Api\Organizer\UpdateOrganizerRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\Organizer;
use Illuminate\Http\Request;
use Response;


class OrganizerController extends Controller
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
        $organizer = Organizer::withTrashed()->fromRequest($request);
        //paginate()分頁處理，appends()添加所需要的參數到分頁連結中。例如:http://laravel.app?page=2
        $paginator = $organizer->paginate(10)->appends($request->input());
        //噴json格式的分頁結果,成功後跳200代碼(請求成功)
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Organizer\CreateOrganizerRequest $request
     * @return \Illuminate\Http\Response
     */

    //POST，儲存資料
    public function store(CreateOrganizerRequest $request)
    {
        Log::record('Organizer', 'create', json_encode(['data' => $request->all()]));
        $organizer = organizer::create($request->all());
        $organizer->save();
        return Response::json($organizer, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Organizer  $EventType
     * @return \Illuminate\Http\Response
     */

    //GET，顯示某筆資料
    public function show(Organizer $organizer)
    {
        return Response::json($organizer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Organizer\UpdateOrganizerRequest  $request
     * @param  \App\Model\Eloquent\Organizer  $EventType
     * @return \Illuminate\Http\Response
     */

    //PUT/PATCH，更新某筆資料
    public function update(UpdateOrganizerRequest $request, Organizer $organizer)
    {
        Log::record('organizer', 'update', json_encode(['data' => $request->all()]));
        //fill()填充屬性陣列
        $organizer->fill($request->all());
        //isDirty()判斷模型是否更改過
        if ($organizer->isDirty()) {
            $organizer->save();
        } else {
            //更新模型的時間戳
            $organizer->touch();
        }
        return Response::json($organizer, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\Organizer  $EventType
     * @return \Illuminate\Http\Response
     */

    //刪除模型
    public function delete(Organizer $organizer)
    {
        //toArray()將集合轉換成純 PHP 陣列
        Log::record('Organizer', 'delete', json_encode(['data' => $organizer->toArray()]));
        $organizer->delete();
        return Response::json($organizer, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Organizer  $EventType
     * @return \Illuminate\Http\Response
     */

    //恢復被軟刪除的模型
    public function restore(Organizer $organizer)
    {
        Log::record('Organizer', 'restore', json_encode(['data' => $organizer->toArray()]));
        $organizer->restore();
        return Response::json($organizer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Organizer  $EventType
     * @return \Illuminate\Http\Response
     */

    //DELETE，刪除某筆資料
    public function destroy(Organizer $organizer)
    {
        Log::record('Organizer', 'destroy', json_encode(['data' => $organizer->toArray()]));
        //forceDelete從模型資料庫刪除
        $organizer->forceDelete();
        return Response::json(null, 200);
    }
}
