<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\OnlyCreatedAt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Log extends Model
{
    use OnlyCreatedAt;
    use HasCreatedBy;

    public $timestamps = false;

    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['type', 'action', 'data'];

    public static function record($type, $action, $data = null)
    {
        return static::create([
            'type' => $type,
            'action' => $action,
            'data' => $data,
        ]);
    }

    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) {
            $queryFilter = $request->get('filter');
            if (array_key_exists('creator.username', $queryFilter)) {
                $query->whereHas('creator', function ($q) use ($queryFilter) {
                    return $q->where('username', 'like', '%' . $queryFilter['creator.username'] . '%');
                });
            }
            if (array_key_exists('type', $queryFilter)) {
                $query->where('type', 'like', '%' . $queryFilter['type'] . '%');
            }
            if (array_key_exists('action', $queryFilter)) {
                $query->where('action', 'like', '%' . $queryFilter['action'] . '%');
            }
            if (array_key_exists('data', $queryFilter)) {
                $query->where('data', 'like', '%' . $queryFilter['data'] . '%');
            }
            if (array_key_exists('created_at', $queryFilter)) {
                $query->where('created_at', 'like', '%' . $queryFilter['created_at'] . '%');
            }
        }
        if ($request->has('orderBy')) {
            $queryOrder = $request->get('orderBy');
            if (array_key_exists('created_at', $queryOrder)) {
                switch ($queryOrder['created_at']) {
                    case 'ascend':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            }
        }
        return $query;
    }
}
