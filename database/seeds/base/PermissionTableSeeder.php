<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissionGroup('user');
        $this->createPermissionGroup('role', ['disable']);
        $this->createPermissionGroup('config', ['disable','create','delete']);
        $this->createPermissionGroup('log', ['disable','create','edit','delete']);
        $this->createPermissionGroup('eventtype');
    }

    public function createPermissionGroup($preslug = "", $withOut = [])
    {
        $ary = ['index', 'create', 'edit', 'disable', 'delete'];
        foreach ($ary as $value) {
            if (!in_array($value, $withOut)) {
                Permission::create([
                    'name' => $preslug . '.' . $value,
                    'slug' => $preslug . '.' . $value,
                ]);
            }
        }
    }
}
