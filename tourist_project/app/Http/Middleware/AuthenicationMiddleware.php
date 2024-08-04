<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthenicationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('jwt_token');
        if (!$token) {
            return redirect()->route('login.user');
        }
        try {
            $user = JWTAuth::setToken($token)->authenticate();
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Bạn cần đăng nhập để tiếp tục thao tác.']);
        }
        return $next($request);
    }
}
