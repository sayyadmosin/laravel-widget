<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Get the origin from the request
        $origin = $request->header('Origin');
        
        // List of allowed origins
        $allowedOrigins = [
            'http://localhost',
            'http://localhost:8080',
            'http://127.0.0.1',
            'http://127.0.0.1:8080'
        ];
        
        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization, X-CSRF-TOKEN');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400'); // 24 hours
        }

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            // Return response for preflight
            return response()->json('OK', 200)
                ->withHeaders($response->headers->all());
        }
        
        return $response;
    }
} 