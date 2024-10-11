<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AttendeeController extends Controller
{
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

    public function logout (Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->noContent();
    }
}
