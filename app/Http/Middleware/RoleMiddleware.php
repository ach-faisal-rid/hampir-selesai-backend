<?php

namespace App\Http\Middleware;

use Closure;
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
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::guard('api')->check()) {
            // return redirect('/login');
            // Kembalikan pesan kesalahan "Tidak sah" dengan status code 401
            return response()->json([
                'error' => 'Tidak sah'
            ], 401);
        }

        $user = Auth::guard('api')->user();

        if($user->role !== $role){
            // Kembalikan pesan kesalahan "Akses ditolak" dengan status code 403
            return response()->json([
                'error' => 'Akses ditolak'
            ], 403);
        }

        return $next($request);
    }
}
