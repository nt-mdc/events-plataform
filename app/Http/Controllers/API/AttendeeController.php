<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * @group User management
 *
 * This API provides comprehensive authentication management capabilities, including user registration, login, and logout operations.
 * Its endpoints allow for secure user authentication, issuance of access tokens, ensuring data protection and adherence to security best practices.
 *
 */

class AttendeeController extends Controller
{


    /**
     * Register a new attendee.
     * 
     * This endpoint allows an attendee to register a new account.
     * 
     * @bodyParam name string required The name of the attendee. Example: Jane Doe
     * @bodyParam email string required The email of the attendee. This email must be unique. Example: jane.doe@example.com
     * @bodyParam password string required The attendee's password. Must be at least 8 characters long. Example: teste123
     * @bodyParam password_confirmation string required Password confirmation must match the password.
     * 
     * @response 201 {
     *   "access_token": "1|XXYYZZ",
     *   "token_type": "Bearer",
     *   "attendee": {
     *       "name": "Jane Doe",
     *       "email": "jane.doe@example.com",
     *       "updated_at": "2024-10-11T13:50:23.000000Z",
     *       "created_at": "2024-10-11T13:50:23.000000Z",
     *       "id": 78
     *   }
     * }
     * 
     * @response 422 {
     *   "message": "The name field is required. (and 5 more errors)",
     *   "errors": {
     *       "name": [
     *           "The name field is required."
     *       ],
     *       "email": [
     *           "The email has already been taken."
     *       ],
     *       "password": [
     *           "The password must be at least 8 characters."
     *       ],
     *       "password_confirmation": [
     *           "The password confirmation does not match."
     *       ]
     *   }
     * }
     */
    public function register (Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Attendee::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $attendee = Attendee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    
        $token = $attendee->createToken('api_token')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'attendee' => $attendee,
        ], 201);
    }


    /**
     * Login an attendee.
     * 
     * This endpoint allows an attendee to log in by providing valid credentials.
     * 
     * @bodyParam email string required The email of the attendee. Example: jane.doe@example.com
     * @bodyParam password string required The attendee's password. Must be at least 8 characters long. Example: teste123
     * 
     * @response 200 {
     *   "access_token": "1|XXYYZZ",
     *   "token_type": "Bearer",
     *   "attendee": {
     *       "name": "Jane Doe",
     *       "email": "jane.doe@example.com",
     *       "updated_at": "2024-10-11T13:50:23.000000Z",
     *       "created_at": "2024-10-11T13:50:23.000000Z",
     *       "id": 78
     *   }
     * }
     * 
     * @response 401 {
     *   "message": "Invalid Credentials"
     * }
     * 
     * @response 422 {
     *   "message": "The email field is required. (and 1 more error)",
     *   "errors": {
     *       "email": [
     *           "The email field is required."
     *       ],
     *       "password": [
     *           "The password field is required."
     *       ]
     *   }
     * }
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:attendees',
            'password' => ['required', Rules\Password::defaults()]
        ]);

        $attendee = Attendee::where('email', $data['email'])->first();

        if ($attendee && Hash::check($data['password'], $attendee->password)) {
            $token = $attendee->createToken('api-token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'attendee' => $attendee,
            ]);
        }
    
        return response()->json(['message' => 'Invalid Credentials'], 401);
    }


    /**
     * Logout the attendee.
     * 
     * This endpoint allows the authenticated attendee to log out, revoking all tokens.
     * 
     * @authenticated
     * 
     * @response 204 {}
     * 
     * @response 401 {
     *   "message": "Unauthenticated."
     * }
     */
    public function logout (Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->noContent();
    }
}
