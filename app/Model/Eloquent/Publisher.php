<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Publisher extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */

    protected $fillable = ['publishers'];

    /**
     * 額外設定要被自動轉換為日期物件的欄位
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //表單驗證請求
    public function scopeFromRequest($query, Request $request)
    {
        //has確認集合中是否有給定的鍵
        if ($request->has('filter')) {
            $queryFilter = $request->get('filter');
            if (array_key_exists('publishers', $queryFilter)) {
                $query->where('publishers', 'like', '%' . $queryFilter['publishers'] . '%');
            }
            if (array_key_exists('deleted_at', $queryFilter)) {
                if (is_string($queryFilter['deleted_at'])) {
                    switch ($queryFilter['deleted_at']) {
                        case 'null':
                            $query->whereNull('deleted_at');
                            break;
                        case 'notnull':
                            $query->whereNotNull('deleted_at');
                            break;
                    }
                }
            }
        }
        if ($request->has('orderBy')) {
            $queryOrder = $request->get('orderBy');
            if (array_key_exists('publishers', $queryOrder)) {
                switch ($queryOrder['publishers']) {
                    case 'ascend':
                        $query->orderBy('publishers', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('publishers', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
