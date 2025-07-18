<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // ADDED 'confirmed' RULE HERE
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422 Unprocessable Entity
        }

        $user = User::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role_id'  => 1
        ]);

        $token = $user->createToken('api-token', ['read', 'write'])->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
            'token'   => $token,
        ], Response::HTTP_CREATED); // 201
    }

    /**
     * Authenticate a user and generate a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required', 'string'], // Added 'string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        }

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Incorrect Password',
            ], Response::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Revoke all existing tokens for the user upon successful login for security,
        // or just generate a new one if you allow multiple active tokens.
        // If you want only one active token per user, uncomment the next line:
        // $user->tokens()->delete();

        $token = $user->createToken('api-token', ['read', 'write'])->plainTextToken; // More specific token name and abilities

        return response()->json([
            'message' => 'Logged in successfully',
            'user'    => $user,
            'token'   => $token,
        ], Response::HTTP_OK); // 200
    }

    /**
     * Log out the authenticated user (revoke current token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
//            dd($request->user());
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logged out successfully',
            ], Response::HTTP_OK); // 200 OK
        }

        // This case should ideally not be reached if middleware is correctly set up
        return response()->json([
            'message' => 'No authenticated user found.',
        ], Response::HTTP_UNAUTHORIZED); // Or 400 Bad Request depending on interpretation
    }

    /**
     * Log out the authenticated user from all devices (revoke all tokens).
     * This is an optional additional method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logoutAll(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete(); // This is the key line
            return response()->json([
                'message' => 'Logged out from all devices successfully',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'No authenticated user found.',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
