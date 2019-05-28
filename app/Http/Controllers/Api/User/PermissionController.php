<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Model\Eloquent\Permission;
use Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Permission::all(), 200);
    }
}
