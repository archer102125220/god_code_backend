<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;


class ResearchType extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */

    protected $fillable = ['research_types'];

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
            if (array_key_exists('research_types', $queryFilter)) {
                $query->where('research_types', 'like', '%' . $queryFilter['research_types'] . '%');
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
            if (array_key_exists('research_types', $queryOrder)) {
                switch ($queryOrder['research_types']) {
                    case 'ascend':
                        $query->orderBy('research_types', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('research_types', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
