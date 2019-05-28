<?php

namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['key', 'value'];
}
