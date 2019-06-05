<?php
namespace Database\Seeder\Base;

use App\Model\Eloquent\Publisher;
use Illuminate\Database\Seeder;

class PublisherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['深石數位科技股份有限公司', '佳魁資訊股份有限公司', '碁峰資訊股份有限公司', '崧博出版事業有限公司'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createPublisherGroup($arr[$i]);
        }
    }

    public function createPublisherGroup($publisher)
    {
        Publisher::create([
            'publishers' => $publisher
        ]);
    }
}
