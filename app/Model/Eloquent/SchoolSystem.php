<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class SchoolSystem extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['school_systems'];
    /**
     * 額外設定要被自動轉換為日期物件的欄位
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) { //判斷值是否存在
            $queryFilter = $request->get('filter');
            if (array_key_exists('school_systems', $queryFilter)) { //判斷該鍵值是否存在
                $query->where('school_systems', 'like', '%' . $queryFilter['school_systems'] . '%');
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
            if (array_key_exists('school_systems', $queryOrder)) {
                switch ($queryOrder['school_systems']) {
                    case 'ascend':
                        $query->orderBy('school_systems', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('school_system', 'desc');
                        break;
                }
            }
        }

        return $query;
    }
}
