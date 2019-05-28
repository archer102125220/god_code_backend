<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\UpdateProfileRequest;
use Auth;
use Hash;
use Response;

class ProfileController extends Controller
{

    public function getProfile()
    {
        return Response::json(Auth::user());
    }

    public function postProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->only('name', 'email', 'phone'));
        if ($request->exists('password_old')) {
            if (Hash::check($request->password_old, $user->password)) {
                $user->password = $request->password;
            } else {
                return Response::json(null, 403);
            }
        }
        if ($user->isDirty()) {
            $user->save();
        }
        return Response::json($user, 200);
    }

}
