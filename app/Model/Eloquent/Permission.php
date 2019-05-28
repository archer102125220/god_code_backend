<?php

namespace App\Model\Eloquent;

use Caffeinated\Shinobi\Models\Permission as Model;

use App\Model\Eloquent\Role;

class Permission extends Model
{

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['id', 'slug'];

    /**
     * Permissions can belong to many roles.
     *
     * @return Model
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

}
