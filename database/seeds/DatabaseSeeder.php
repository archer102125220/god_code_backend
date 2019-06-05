<?php

use Database\Seeder\Base\ConfigTableSeeder;
use Database\Seeder\Base\InterestTableSeeder;
use Database\Seeder\Base\PermissionTableSeeder;
use Database\Seeder\Base\RoleTableSeeder;
use Database\Seeder\Base\UserTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(InterestTableSeeder::class);
        $this->call(ConfigTableSeeder::class);

        if (config('app.env') === 'local') { }
    }
}
