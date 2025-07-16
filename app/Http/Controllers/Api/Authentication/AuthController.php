<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Register a new user and return an access token
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                "name" => 'required|string|max:255',
                'phone_number' => 'required|string|max:20|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->accessToken;

            DB::commit();

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            return response()->json(
                ['message' => $exception->getMessage()
                ], 500);
        }
    }

    /**
     * @throws ValidationException
     */
    public function login(ServerRequestInterface $serverRequest, Request $request, ATC $accessTokenController): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'username' => 'required|string|email',
                'password' => 'required|string',
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
            ]);

            $user = $this->userRepository->where('email', $request->username)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            Auth::login($user);

            // Generate API token for SPA
            $tokenData = $user->createToken('auth-token');

            DB::commit();

            return response()->json([
                'user' => $user,
                'token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'expires_in' => $tokenData->token->expires_at->diffInSeconds(now()),
            ]);
        } catch (ValidationException $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            return response()->json(
                ['message' => $exception->getMessage()
                ], 500);
        }
    }
}
