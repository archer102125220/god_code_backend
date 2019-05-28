<?php

namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Model\Traits\Eloquent\OnlyCreatedAt;

class PasswordReset extends Model
{
    use OnlyCreatedAt;

    public $timestamps = false;

    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['user_id', 'token'];
}
