<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = $request->except('password');
        $user['password'] = Hash::make($request->input('password'));
        User::create($user);

        return response()->json([
            'success' => true,
        ], JsonResponse::HTTP_CREATED);
    }
}
