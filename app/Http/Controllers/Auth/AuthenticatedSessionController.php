<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        try {
            // This validates & authenticates via FormRequest
            $request->authenticate();

            // Regenerate session on successful login
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login successful',
                'user' => auth()->user(),
            ]);
        } catch (ValidationException $e) {
            // Return validation errors to front-end
            return response()->json([
                'message' => 'Invalid credentials',
                'errors' => $e->errors(), // maps field => message
            ], 422);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
