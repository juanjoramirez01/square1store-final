<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user registration
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            // Automatically validated via the custom RegisterRequest
            $validatedData = $request->validated();

            // Create User
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'email_verified_at' => now(),
            ]);

            // Create Cart
            $user->createCart();

            // Log Success
            Log::info('User registered successfully', ['user_id' => $user->id, 'email' => $user->email]);

            return response()->json([
                'user' => $user,
                'message' => 'User Registered Successfully',
            ], 201);
        } catch (ValidationException $e) {
            Log::warning('Validation error during registration', ['errors' => $e->errors()]);
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('Error registering user', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'Error registering user', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Handle user login
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            // Automatically validated via the custom LoginRequest
            $validatedData = $request->validated();

            $user = User::where('email', $validatedData['email'])->first();

            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                Log::warning('Invalid login attempt', ['email' => $validatedData['email']]);
                return response()->json(['message' => 'The provided credentials are incorrect'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            Log::info('User logged in successfully', ['user_id' => $user->id]);

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'message' => 'Login successful',
                'token' => $token
            ]);
        } catch (ValidationException $e) {
            Log::warning('Validation error during login', ['errors' => $e->errors()]);
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('Error logging in', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'Error logging in', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Get the authenticated user's profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        try {
            $user = auth()->user();

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching user profile', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'Error fetching user profile', 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Handle user logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $user = auth()->user();
            $user->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Throwable $th) {
            Log::error('Error logging out', ['error' => $th->getMessage()]);
            return response()->json(['message' => 'Error logging out', 'error' => $th->getMessage()], 500);
        }
    }
}
