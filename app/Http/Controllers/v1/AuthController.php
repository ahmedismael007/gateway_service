<?php

namespace App\Http\Controllers\v1;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\v1\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $user_service)
    {
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->user_service->create($data);

        $token = auth('api')->attempt($request->only('email', 'password'));


        event(new UserCreated($user));

        return (new UserResource($user))
            ->additional([
                'token' => $token,
                'message' => trans('auth.register.success'),
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => trans('auth.failed')], 401);
        }

        $user = auth('api')->user();

        $tenant = $user->tenants()->first();

        return (new UserResource($user))
            ->additional(['message' => trans('auth.login.success'), 'token' => $token, 'tenant_id' => $tenant['id']])
            ->response()
            ->setStatusCode(200);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => trans('auth.logout.success')
        ], 200);
    }

    public function confirm_email(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'otp' => 'required|string',
        ]);

        $validated['user_id'] = $user['id'];

        $status = $this->user_service->confirm_email($validated);

        return match ($status) {
            'invalid' => response()->json(['message' => trans('user.confirm.invalid')], 400),
            'expired' => response()->json(['message' => trans('user.confirm.expired')], 400),
            'success' => response()->json(['message' => trans('user.confirm.success')], 200),
        };
    }

    public function send_confirmation_email()
    {
        $user = $this->user_service->find(auth('api')->id());

        event(new UserCreated($user));

        return response()->json(['message' => trans('auth.confirm.sent')], 200);
    }
}
