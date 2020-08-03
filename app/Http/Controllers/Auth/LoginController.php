<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $input = $request->only(['email', 'password']);
        if (!Auth::attempt($input)) {
            return response()->json([
                'error' => 'Login or password are invalid.',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $apiToken = Str::random(80);
        $request->user()->fill(['api_token' => $apiToken])->save();
        return response()->json([
            'api_token' => $apiToken,
        ], JsonResponse::HTTP_OK);
    }
}
