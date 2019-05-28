<?php

namespace Database\Seeder\Base;

use App\Model\Eloquent\Config;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicConfigs = [
            'company.name' => '',
            'company.full_name' => '',
            'company.no' => '',
            'company.address' => '',
            'company.email' => '',
            'company.service_phone' => '',
            'company.phone' => '',
            'company.fax' => '',
            'company.url' => '',
        ];
        $privateConfigs = [
            'mail.driver' => env('MAIL_DRIVER', null),
            'mail.host' => env('MAIL_HOST', null),
            'mail.port' => env('MAIL_PORT', null),
            'mail.username' => env('MAIL_USERNAME', null),
            'mail.password' => env('MAIL_PASSWORD', null),
            'mail.encryption' => env('MAIL_ENCRYPTION', null),
            'mail.from_name' => env('MAIL_FROM_NAME', null),
            'mail.from_address' => env('MAIL_FROM_ADDRESS', null),
        ];
        foreach ($publicConfigs as $key => $val) {
            Config::create([
                'key' => $key,
                'value' => $val,
                'public' => true,
            ]);
        }
        foreach ($privateConfigs as $key => $val) {
            Config::create([
                'key' => $key,
                'value' => $val,
                'public' => false,
            ]);
        }
    }
}
