<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuth {
    
    public function handle(Request $request, Closure $next) {
        try {

            if (!JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'type' => 'auth_error',
                    'message' => 'unauthorized'
                ], 401);
            }

        } catch (TokenExpiredException $e) {

            return response()->json([
                'type' => 'auth_error',
                'message' => 'token_expired'
            ], 401);

        } catch (TokenInvalidException $e) {

            return response()->json([
                'type' => 'auth_error',
                'message' => 'token_invalid'
            ], 401);

        } catch (JWTException $e) {

            return response()->json([
                'type' => 'auth_error',
                'message' => 'token_absent'
            ], 401);

        }

        return $next($request);
    }
}