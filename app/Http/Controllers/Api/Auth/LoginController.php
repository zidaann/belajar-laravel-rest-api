<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        // pengecekan apakah email dan password sama
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login failed',
                'error' => 'Your credentials not match'
            ], 403);
        }


        return response()->json([
            'message' => 'Login Success',
            'token' => Auth::user()->createToken('todo-api')->plainTextToken,
            'status' => 200
        ], 200);
    }
}
