<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\CreateRoleRequest;
use App\Http\Requests\Api\Role\UpdateRoleRequest;
use App\Model\Eloquent\Permission;
use App\Model\Eloquent\Role;
use App\Model\Eloquent\Log;
use Auth;
use Illuminate\Http\Request;
use Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all()->map(function ($role) {
            return array_merge($role->toArray(), [
                'permissions' => $role->getPermissions(),
            ]);
        });
        return Response::json($roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Role\CreateRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
         Log::record('role', 'create', json_encode(['data' => $request->all()]));
        $role_slug = 'role' . time();
        $role_data = [
            'name' => $request->get('name', $role_slug),
            'slug' => $role_slug,
            'special' => (($request->get('allpermission', false)) ? 'all-access' : null),
            'description' => $request->get('description', null),
        ];
        $role = Role::create($role_data);
        if (!$request->get('allpermission', false)) {
            $permission_ids = Permission::whereIn('slug', $request->get('permissions', []))->pluck('id')->all();
            $role->syncPermissions($permission_ids);
            $role->save();
        }
        return Response::json(array_merge($role->toArray(), [
            'permissions' => $role->getPermissions(),
        ]), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return Response::json(array_merge($role->toArray(), [
            'permissions' => $role->getPermissions(),
        ]), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Role\UpdateRoleRequest  $request
     * @param  \App\Model\Eloquent\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        Log::record('role', 'update', json_encode(['data' => $request->all()]));
        if (Auth::user()->isRole($role->slug)) {
            return Response::json(null, 403);
        }
        $role->fill([
            'name' => $request->get('name', $role->name),
            'special' => (($request->get('allpermission', false)) ? 'all-access' : null),
            'description' => $request->get('description', null),
        ]);
        if (!$request->get('allpermission', false)) {
            $permission_ids = Permission::whereIn('slug', $request->get('permissions', []))->pluck('id')->all();
            $role->syncPermissions($permission_ids);
        }
        $role->save();
        return Response::json(array_merge($role->toArray(), [
            'permissions' => $role->getPermissions(),
        ]), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Log::record('role', 'destroy', json_encode(['data' => $role->toArray()]));
        if (Auth::user()->isRole($role->slug)) {
            return Response::json(null, 403);
        }
        $role->delete();
        return Response::json(null, 200);
    }
}
