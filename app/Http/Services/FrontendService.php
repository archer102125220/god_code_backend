<?php
namespace App\Http\Services;

use Config;

class FrontendService
{
    public static function url($path = null, $parameter = [])
    {
        $history = Config::get('frontend.history');
        switch ($history) {
            case 'hash':
                return static::getHashedUrl($path, $parameter);
            case 'route':
                return static::getRouteUrl($path, $parameter);
            default:
                return '';
        }
    }

    public static function getHashedUrl($path = null, $parameter = [])
    {
        $baseUrl = Config::get('frontend.url');
        $route = is_null($path) ? '/' : $path;
        $params = (count($parameter) === 0) ? '' : ('?' . http_build_query($parameter));
        return $baseUrl . '/#' . $route . $params;
    }

    public static function getRouteUrl($path = null, $parameter = [])
    {
        $baseUrl = Config::get('frontend.url');
        $route = is_null($path) ? '/' : $path;
        $params = (count($parameter) === 0) ? '' : ('?' . http_build_query($parameter));
        return $baseUrl . $route . $params;
    }

}
