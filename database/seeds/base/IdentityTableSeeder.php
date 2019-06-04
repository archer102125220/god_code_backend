<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\Identity;
use Illuminate\Database\Seeder;

class IdentityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['老師', '研究生', 'Lab 1.0', 'Lab 2.0', 'Lab 3.0', 'Lab 4.0', 'Lab 5.0', 'Lab 6.0', 'Lab 7.0', 'Lab 8.0', 'Lab 9.0'];
        for ($i = 0; $i < count($arr); $i++) {
            $this->createIdentityGroup($arr[$i]);
        }
    }

    public function createIdentityGroup($identity)
    {
        Identity::create([
            'identities' => $identity
        ]);
    }
}
