<?php

namespace App\Model\Eloquent;

use App\Model\Traits\Eloquent\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Storage;

class File extends Model
{
    use HasCreatedBy;

    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['unit', 'referable_type', 'referable_id', 'name', 'path', 'realpath', 'extension', 'mimetype', 'size'];

    public function referable()
    {
        return $this->morphTo();
    }

    public function scopeUnit($query, $unitName)
    {
        return $query->where('unit', $unitName);
    }

    public function hasRefer() {
        return !is_null($this->referable_type) || !is_null($this->referable_id);
    }

    public function bindRefer(String $model = null, int $model_id = null)
    {
        $this->fill([
            'referable_type' => $model,
            'referable_id' => $model_id,
        ]);
        $this->save();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $attributes = parent::toArray();
        $attributes['url'] = Storage::url($this->getAttribute('realpath'));
        return $attributes;
    }

    public function scopeFromRequest($query, Request $request)
    {
        if ($request->has('filter')) {
            $queryFilter = $request->get('filter');
            if (array_key_exists('name', $queryFilter)) {
                $query->where('name', 'like', '%' . $queryFilter['name'] . '%');
            }
            if (array_key_exists('extension', $queryFilter)) {
                $query->where('extension', 'like', '%' . $queryFilter['extension'] . '%');
            }
            if (array_key_exists('unit', $queryFilter)) {
                $query->where('unit', 'like', '%' . $queryFilter['unit'] . '%');
            }
            if (array_key_exists('created_at', $queryFilter)) {
                $query->where('created_at', 'like', '%' . $queryFilter['created_at'] . '%');
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
            if (array_key_exists('name', $queryOrder)) {
                switch ($queryOrder['name']) {
                    case 'ascend':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('name', 'desc');
                        break;
                }
            }
            if (array_key_exists('extension', $queryOrder)) {
                switch ($queryOrder['extension']) {
                    case 'ascend':
                        $query->orderBy('extension', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('extension', 'desc');
                        break;
                }
            }
            if (array_key_exists('unit', $queryOrder)) {
                switch ($queryOrder['unit']) {
                    case 'ascend':
                        $query->orderBy('unit', 'asc');
                        break;
                    case 'descend':
                        $query->orderBy('unit', 'desc');
                        break;
                }
            }
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
