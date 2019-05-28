<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\ModifySelfException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CreateUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Model\Eloquent\User;
use App\Model\Eloquent\Log;
use Auth;
use Illuminate\Http\Request;
use Response;

class UserController extends Controller
{

    /**
     * Test if try modify the model relation with current user
     *
     * @param \App\Model\Eloquent\User $user The model will be modify
     * @throws \App\Exceptions\ModifySelfException When the model is relation with current user
     */
    public function preventModifySelf(User $user)
    {
        if (Auth::id() === $user->id) {
            throw new ModifySelfException();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(User::with(['roles'])->withTrashed()->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\User\CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        Log::record('user', 'create', json_encode(['data' => $request->all()]));
        $user = User::create($request->only('username', 'password', 'name', 'email', 'phone'));
        if ($request->exists('role_id')) {
            $user->assignRole($request->role_id);
        }
        $user->save();
        return Response::json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Response::json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\User\UpdateUserRequest  $request
     * @param  \App\Model\Eloquent\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        Log::record('user', 'update', json_encode(['data' => $request->all()]));
        $user->fill($request->only('name', 'email', 'phone'));
        if ($request->exists('password')) {
            $user->password = $request->password;
        }
        if ($request->exists('role_id')) {
            $user->syncRoles([$request->role_id]);
        }
        if ($user->isDirty()) {
            $user->save();
        }
        return Response::json($user, 200);
    }

    /**
     * Soft Delete the specified resource in storage.
     *
     * @param  \App\Model\Eloquent\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        Log::record('user', 'delete', json_encode(['data' => $user->toArray()]));
        $this->preventModifySelf($user);
        $user->delete();
        return Response::json($user, 200);
    }

    /**
     * Restore soft delete the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(User $user)
    {
        Log::record('user', 'restore', json_encode(['data' => $user->toArray()]));
        $this->preventModifySelf($user);
        $user->restore();
        return Response::json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Eloquent\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Log::record('user', 'destroy', json_encode(['data' => $user->toArray()]));
        $this->preventModifySelf($user);
        $user->forceDelete();
        return Response::json(null, 200);
    }
}
