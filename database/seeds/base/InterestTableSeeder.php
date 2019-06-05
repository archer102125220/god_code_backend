<?php
namespace Database\Seeder\Base;

use App\Model\Eloquent\Interest;
use Illuminate\Database\Seeder;

class InterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['聽音樂', '看電影', '看書', '打電動'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createInterestGroup($arr[$i]);
        }
    }

    public function createInterestGroup($interest)
    {
        Interest::create([
            'interests' => $interest
        ]);
    }
}
