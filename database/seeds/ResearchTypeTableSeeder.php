<?php
namespace Database\Seeder\Base;

use App\Model\Eloquent\ResearchType;
use Illuminate\Database\Seeder;

class ResearchTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['網頁前端', '網頁後端', '手機應用程式'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createResearchTableGroup($arr[$i]);
        }
    }

    public function createResearchTableGroup($researchType)
    {
        ResearchType::create([
            'research_types' => $researchType
        ]);
    }
}
