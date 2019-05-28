<?php

namespace App\Http\Controllers\Api\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Config\UpdateConfigRequest;
use App\Model\Eloquent\Config;
use App\Model\Eloquent\Log;
use Response;

class ConfigController extends Controller
{
    public function index()
    {
        return Response::json(Config::all()->reduce(function ($carry, $item) {
            $carry[$item->key] = $item->value;
            return $carry;
        }, []), 200);
    }

    public function update(UpdateConfigRequest $request)
    {
        Log::record('config', 'update', json_encode(['data' => $request->all()]));
        $configs = $request->get('configs', []);
        foreach ($configs as $config) {
            Config::where('key', $config['key'])->update(['value' => $config['value']]);
        }
        return Response::json(Config::all()->reduce(function ($carry, $item) {
            $carry[$item->key] = $item->value;
            return $carry;
        }, []), 200);
    }
}
