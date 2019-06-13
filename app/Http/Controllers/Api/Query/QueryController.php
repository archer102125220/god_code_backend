<?php

namespace App\Http\Controllers\Api\Query;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class QueryController extends Controller
{

    protected $invokeMap = [
        'user/checkConflict' => 'userCheckConflict',
        'role' => 'role',
        'event_type' => 'event_type',
    ];

    protected function getQueryBuilder($builder, ?Request $_request = null, ?array $allowExtendQuery = [])
    {
        $request = $_request ?? request();

        return new QueryBuilder($builder, $request);
    }

    /**
     * Query Entrypoint
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $modelName, $action = null)
    {
        $invokeKey = $modelName . ((!is_null($action)) ? ('/' . $action) : '');
        $invokeFuncName = array_key_exists($invokeKey, $this->invokeMap) ? $this->invokeMap[$invokeKey] : null;
        if (is_null($invokeFuncName)) {
            return Response::json(null, 400);
        }
        if (is_callable([$this, $invokeFuncName])) {
            return call_user_func([$this, $invokeFuncName], $request);
        }
        return Response::json(null, 400);
    }

    public function userCheckConflict(Request $request)
    {
        if (!$request->exists('username')) {
            return Response::json(null, 400);
        }
        $username = $request->get('username', '');
        $user = \App\Model\Eloquent\User::withTrashed()->where('username', $username)->first();
        return Response::json([
            'conflict' => !is_null($user),
        ], 200);
    }

    public function role(Request $request)
    {
        $allowFields = ['id', 'name'];
        $roles = $this->getQueryBuilder(\App\Model\Eloquent\Role::select($allowFields))->allowedFields($allowFields)->get();
        return Response::json($roles, 200);
    }

    public function event_type(Request $request)
    {
        $allowFields = ['id', 'event_types'];
        $allowFilters = [
            Filter::exact('id'),
        ];
        $eventTypes = $this->getQueryBuilder(\App\Model\Eloquent\EventType::select($allowFields))->allowedFields($allowFields)->allowedFilters($allowFilters)->get();
        return Response::json($eventTypes, 200);
    }
}
