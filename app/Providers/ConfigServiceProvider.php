<?php

namespace App\Providers;

use App\Model\Eloquent\Config as ConfigEloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('configs')) {
            $configKeys = [
                'mail.driver',
                'mail.host',
                'mail.port',
                'mail.username',
                'mail.password',
                'mail.encryption',
                'mail.from_name',
                'mail.from_address',
            ];
            $configs = ConfigEloquent::whereIn('key', $configKeys)->get();
            $defaultMailConfig = Config::get('mail');
            $mailConfig = [
                'driver' => $this->getValueFromConfigs($configs, 'mail.driver', $defaultMailConfig['driver']),
                'host' => $this->getValueFromConfigs($configs, 'mail.host', $defaultMailConfig['host']),
                'port' => $this->getValueFromConfigs($configs, 'mail.port', $defaultMailConfig['port']),
                'username' => $this->getValueFromConfigs($configs, 'mail.username', $defaultMailConfig['username']),
                'password' => $this->getValueFromConfigs($configs, 'mail.password', $defaultMailConfig['password']),
                'encryption' => $this->getValueFromConfigs($configs, 'mail.encryption', $defaultMailConfig['encryption']),
                'from' => [
                    'name' => $this->getValueFromConfigs($configs, 'mail.from_name', $defaultMailConfig['from']['name']),
                    'address' => $this->getValueFromConfigs($configs, 'mail.from_address', $defaultMailConfig['from']['address']),
                ],
            ];
            Config::set('mail', array_merge($defaultMailConfig, $mailConfig));
        }
    }

    protected function getValueFromConfigs(Collection $configs, String $key, String $defaultValue = null)
    {
        $config = $configs->firstWhere('key', $key);
        if (is_null($config)) {
            return $defaultValue;
        }
        return $config->value;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
