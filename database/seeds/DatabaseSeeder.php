<?php

use Database\Seeder\Base\ConfigTableSeeder;
use Database\Seeder\Base\EventTableSeeder;
use Database\Seeder\Base\ExpertiseTableSeeder;
use Database\Seeder\Base\IdentityTableSeeder;
use Database\Seeder\Base\InterestTableSeeder;
use Database\Seeder\Base\OrganizerTableSeeder;
use Database\Seeder\Base\PermissionTableSeeder;
use Database\Seeder\Base\ResearchTypeTableSeeder;
use Database\Seeder\Base\PublisherTableSeeder;
use Database\Seeder\Base\RoleTableSeeder;
use Database\Seeder\Base\SchoolSystemTableSeeder;
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
        $this->call(IdentityTableSeeder::class);
        $this->call(SchoolSystemTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OrganizerTableSeeder::class);
        $this->call(PublisherTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(ResearchTypeTableSeeder::class);
        $this->call(InterestTableSeeder::class);
        $this->call(ExpertiseTableSeeder::class);
        $this->call(ConfigTableSeeder::class);

        if (config('app.env') === 'local') { }
    }
}
