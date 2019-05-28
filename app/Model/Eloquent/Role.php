<?php

namespace App\Model\Eloquent;

use App\Model\Eloquent\Permission;
use Auth;
use Caffeinated\Shinobi\Models\Role as Model;
use JWTAuth;

class Role extends Model
{
    /**
     * 指定可被使用者建立或更新的模型屬性。
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'special'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'name', 'slug', 'description', 'special'];

    /**
     * Roles can have many permissions.
     *
     * @return Model
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }


}
