<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class EventType extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
     /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */

    protected $fillable = ['event_types'];

    /**
     * 額外設定要被自動轉換為日期物件的欄位
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) { //確定值是否存在
            $queryFilter = $request->get('filter');
            if (array_key_exists('event_types', $queryFilter)) { //判斷該鍵是否存在
                $query->where('event_types', 'like', '%' . $queryFilter['event_types'] . '%');
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
            if (array_key_exists('event_types', $queryOrder)) {
                switch ($queryOrder['event_types']) {
                    case 'ascend':
                        $query->orderBy('event_types', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('event_types', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
