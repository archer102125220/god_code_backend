<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\Organizer;
use Illuminate\Database\Seeder;

class OrganizerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['經濟部工業局','教育部資訊及科技教育司','中華民國資訊管理學會'];
        for($i=0;$i<count($arr);$i++){
            $this->createOrganizerGroup($arr[$i]);
        }
    }

    public function createOrganizerGroup($organizer){
        Organizer::create([
            'organizers' => $organizer
        ]);
    }
}
