<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        // ตรวจสอบบทบาทผู้ใช้
        $user = Auth::user();
        if ($user->status !== $role) {
            return redirect('/not_service')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }


        return $next($request);
    }
}
