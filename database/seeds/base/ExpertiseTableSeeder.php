<?php
namespace Database\Seeder\Base;

use App\Model\Eloquent\Expertise;
use Illuminate\Database\Seeder;

class ExpertiseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['文書處理', '現場簡報', '製作PPT'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createExpertiseGroup($arr[$i]);
        }
    }

    public function createExpertiseGroup($expertise)
    {
        Expertise::create([
            'expertises' => $expertise
        ]);
    }
}
