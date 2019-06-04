<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\SchoolSystem;
use Illuminate\Database\Seeder;

class SchoolSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['研究生', '在職研究生', '(日)四技', '(夜)四技', '二技資管', '二技資應', '五專資管', '五專資應'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createSchoolSystemGroup($arr[$i]);
        }
    }

    public function createSchoolSystemGroup($schoolSystems)
    {
        SchoolSystem::create([
            'school_systems' => $schoolSystems
        ]);
    }
}
