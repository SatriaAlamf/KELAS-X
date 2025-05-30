<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        
        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
}