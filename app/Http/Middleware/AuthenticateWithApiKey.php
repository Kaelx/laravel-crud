<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;

class AuthenticateWithApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Get API key from header
        $apiKey = $request->header('api_key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is required'
            ], 401);
        }


        // Find the API key in database
        $keyModel = ApiKey::where('key', $apiKey)->first();

        if (!$keyModel) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }

        // Update last used timestamp
        $keyModel->markAsUsed();

        // Set the authenticated user
        auth()->setUser($keyModel->user);
        $request->merge(['api_key' => $keyModel]);


        return $next($request);
    }
}
