<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiKeyController extends Controller
{
    /**
     * Generate a new API key for a user
     * POST /api/keys/generate
     */
    public function generate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify user credentials
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Generate API key
        $apiKey = ApiKey::create([
            'user_id' => $user->id,
            'key' => ApiKey::generate(),
            'name' => $request->name ?? 'Default Key',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'API key generated successfully',
            'data' => [
                'api_key' => $apiKey->key,
                'name' => $apiKey->name,
                'created_at' => $apiKey->created_at,
            ]
        ], 201);
    }
}
