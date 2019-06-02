<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Identity extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['identities'];
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
            if (array_key_exists('indentities', $queryFilter))
                $query->where('identities', 'like', '%' . $queryFilter['identityes'] . '%');

            if (array_key_exists('deleted_at', $queryFilter)) {

                if (is_string($queryFilter['deleted_at'])) {
                    switch ($queryFilter['deleted_at']) {
                        case 'null':
                            $query->wherenull('deleted_at');
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
            if (array_key_exists('identities', $queryOrder)) {
                switch ($queryOrder['identities']) {
                    case 'ascend':
                        $query->orderBy('identities', 'asc');
                        break;
                    case 'descendd':
                        $query->orderBy('identities', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
