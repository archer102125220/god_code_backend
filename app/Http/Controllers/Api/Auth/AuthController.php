<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ProcessResetPasswordRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Services\FrontendService;
use App\Model\Eloquent\Log;
use App\Model\Eloquent\PasswordReset;
use App\Model\Eloquent\User;
use Auth;
use Beautymail;
use JWTAuth;
use Response;

class AuthController extends Controller
{

    public function postlogin(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return Response::json(null, 403);
        }
        $user = User::where('username', $credentials['username'])->firstOrFail();
        Log::record('auth', 'login', json_encode(['ip' => $request->ip()]));
        return Response::json(array_merge([
            'roles' => $user->roles->toArray(),
            'permissions' => $user->getPermissions(),
        ], compact("token")));
    }

    public function getRefresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        $user = Auth::user();
        return Response::json(array_merge([
            'roles' => $user->roles->toArray(),
            'permissions' => $user->getPermissions(),
        ], compact("token")));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where($request->only('username', 'email'))->firstOrFail();
        Log::record('auth', 'reset.password', json_encode(['userId' => $user->id, 'data' => $request->all()]));
        $passwordReset = PasswordReset::create([
            'user_id' => $user->id,
            'token' => str_random(50),
        ]);
        Beautymail::send('emails.password', [
            'user' => $user,
            'resetUrl' => FrontendService::url('/resetpassword', ['token' => $passwordReset->token]),
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject('變更帳戶密碼');
        });
        return Response::json(null, 200);
    }

    public function processResetPassword(ProcessResetPasswordRequest $request)
    {
        $passwordReset = PasswordReset::where('token', $request->get('token', null))->firstOrFail();
        $user = User::findOrFail($passwordReset->user_id);
        $user->password = $request->get('password');
        $user->save();
        $passwordReset->delete();
        return Response::json(null, 200);
    }

}
