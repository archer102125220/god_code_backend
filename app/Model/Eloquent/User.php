<?php

namespace App\Model\Eloquent;

use App\Model\Eloquent\Role;
use App\Model\Traits\Eloquent\HasCreatedBy;
use App\Model\Traits\Eloquent\HasUpdatedBy;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use ShinobiTrait;
    use HasCreatedBy, HasUpdatedBy;

    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'name', 'email', 'phone'];

    /**
     * 指定轉換成JSON或Array格式時所要隱藏的模型屬性。
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * 設定 password 屬性的值
     *
     * @param  mixed  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Users can have many roles.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

}
