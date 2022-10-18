<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::query()->where(["email" => $request->email])->first();
        if(Hash::check($request->password, $user->password)){
            Auth::login($user);
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        return response()->json([
           "password" => ["Le mot de passe n'est pas bon"],
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::query()->create([
            "password" => Hash::make($request->password),
            "email" => $request->email,
            "name" => $request->name,
        ]);

        $user->save();
        $user->assignRole("user");
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

    /**
     * @param Request $request
     * @return User
     */
    public function info(Request $request): User
    {
        return $request->user();
    }
}
