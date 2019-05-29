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
            'number' => '131',
            'name' => '系統管理者',
            'email' => 'admin@mail.com',
            'introduction' => '123'
        ]);
        $admin->assignRole($role['admin']->id);
        $admin->save();
    }
}
