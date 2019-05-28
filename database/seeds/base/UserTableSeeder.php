<?php

namespace Database\Seeder\Base;

use Illuminate\Database\Seeder;

use App\Model\Eloquent\User;
use App\Model\Eloquent\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            'admin' => Role::where('slug', 'admin')->firstOrFail()
        ];

        $admin = User::create([
            'username' => 'admin',
            'password' => 'admin',
            'name' => '系統管理者',
            'email' => 'admin@mail.com',
        ]);
        $admin->assignRole($role['admin']->id);
        $admin->save();
    }
}
