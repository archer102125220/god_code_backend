<?php

namespace App\Model\Eloquent;

use App\Model\Eloquent\EventType;
use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use App\Model\Traits\Eloquent\IncludeFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class EventAlbum extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    use IncludeFiles;
     /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */

    protected $fillable = ['event_albums', 'event_type_id'];

    /**
     * 額外設定要被自動轉換為日期物件的欄位
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) { //確定值是否存在
            $queryFilter = $request->get('filter');
            if (array_key_exists('event_albums', $queryFilter)) { //判斷該鍵是否存在
                $query->where('event_albums', 'like', '%' . $queryFilter['event_albums'] . '%');
            }
            if (array_key_exists('event_type.event_types', $queryFilter)) {
                $query->whereHas('eventType', function ($q) use ($queryFilter) {
                    return $q->where('event_types', 'like', '%' . $queryFilter['event_type.event_types'] . '%');
                });
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
            if (array_key_exists('event_albums', $queryOrder)) {
                switch ($queryOrder['event_albums']) {
                    case 'ascend':
                        $query->orderBy('event_albums', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('event_albums', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
