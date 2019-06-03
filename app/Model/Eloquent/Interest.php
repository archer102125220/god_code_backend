<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBY;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Interest extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['interests'];
    /**
     * 額外設定要被自動轉換為日期物件的欄位
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) {
            $queryFilter = $request->get('filter');
            if (array_key_exists('interests', $queryFilter))
                $query->where('interests', 'like', '%' . $queryFilter['interests'] . '%');
            if (array_key_exists('deleted_at', $queryFilter)) {
                if (is_string($queryFilter['deleted_at'])) {
                    switch ($queryFilter['deleted_at']) {
                        case 'null':
                            $query->whereNull('delete_at');
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
            if (array_key_exists('interests', $queryOrder)) {
                switch ($queryOrder['interests']) {
                    case 'ascend':
                        $query->orderBy('interests', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('interests', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
