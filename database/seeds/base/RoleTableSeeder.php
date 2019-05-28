<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => '系統管理員',
            'special' => 'all-access',
        ]);
    }
}
