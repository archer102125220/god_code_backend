<?php
namespace Database\Seeder\Base;

use App\Model\Eloquent\EventType;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['競賽', '專題', '聚餐'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createEventTypeGroup($arr[$i]);
        }
    }

    public function createEventTypeGroup($eventType)
    {
        EventType::create([
            'event_types' => $eventType
        ]);
    }
}
