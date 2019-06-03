<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Expertise extends Model
{
    use SoftDeletes;
    use HasCreatedBy, HasUpdatedBy;
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['expertises'];
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
            if (array_key_exists('expertises', $queryFilter))
                $query->where('expertises', 'like', '%' . $queryFilter['expertises'] . '%');
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
            if(array_key_exists('expertises',$queryOrder)){
                switch($queryOrder['expertises']){
                    case 'ascend':
                        $query->orderBy('expertises','asc');
                        break;
                    case 'descend':
                        $query->orderBy('expertises','desc');
                        break;
                }
            }
        }
        return $query;
    }
}
