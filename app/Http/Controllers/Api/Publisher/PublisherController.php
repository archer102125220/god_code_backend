<?php

namespace App\Http\Controllers\Api\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploader;
use App\Http\Requests\Api\Publisher\CreatePublisherRequest;
use App\Http\Requests\Api\Publisher\UpdatePublisherRequest;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\Publisher;
use Illuminate\Http\Request;
use Response;

class PublisherController extends Controller
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
        $publisher = Publisher::withTrashed()->fromRequest($request);
        //paginate()分頁處理，appends()添加所需要的參數到分頁連結中。例如:http://laravel.app?page=2
        $paginator = $publisher->paginate(10)->appends($request->input());
        //噴json格式的分頁結果,成功後跳200代碼(請求成功)
        return Response::json($paginator, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Organizer\CreatePublisherRequest $request
     * @return \Illuminate\Http\Response
     */

    //POST，儲存資料
    public function store(CreatePublisherRequest $request)
    {
        Log::record('Publisher', 'create', json_encode(['data' => $request->all()]));
        $publisher = publisher::create($request->all());
        $publisher->save();
        return Response::json($publisher, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Publisher  $EventType
     * @return \Illuminate\Http\Response
     */

    //GET，顯示某筆資料
    public function show(Publisher $publisher)
    {
        return Response::json($publisher, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Publisher\UpdatePublisherRequest  $request
     * @param  \App\Model\Eloquent\Publisher  $EventType
     * @return \Illuminate\Http\Response
     */

    //PUT/PATCH，更新某筆資料
    public function update(UpdatePublisherRequest $request, Publisher $publisher)
    {
        Log::record('publisher', 'update', json_encode(['data' => $request->all()]));
        //fill()填充屬性陣列
        $publisher->fill($request->all());
        //isDirty()判斷模型是否更改過
        if ($publisher->isDirty()) {
            $publisher->save();
        } else {
            //更新模型的時間戳
            $publisher->touch();
        }
        return Response::json($publisher, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\Publisher  $EventType
     * @return \Illuminate\Http\Response
     */

    //刪除模型
    public function delete(Publisher $publisher)
    {
        //toArray()將集合轉換成純 PHP 陣列
        Log::record('Publisher', 'delete', json_encode(['data' => $publisher->toArray()]));
        $publisher->delete();
        return Response::json($publisher, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Publisher  $EventType
     * @return \Illuminate\Http\Response
     */

    //恢復被軟刪除的模型
    public function restore(Publisher $publisher)
    {
        Log::record('Publisher', 'restore', json_encode(['data' => $publisher->toArray()]));
        $publisher->restore();
        return Response::json($publisher, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Publisher  $EventType
     * @return \Illuminate\Http\Response
     */

    //DELETE，刪除某筆資料
    public function destroy(Publisher $publisher)
    {
        Log::record('Publisher', 'destroy', json_encode(['data' => $publisher->toArray()]));
        //forceDelete從模型資料庫刪除
        $publisher->forceDelete();
        return Response::json(null, 200);
    }
}
