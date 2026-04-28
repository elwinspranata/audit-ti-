<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role !== 'admin') {
            if (!$user->hasActiveSubscription()) {
                return redirect()->route('pricing.index')
                    ->with('error', 'Anda harus berlangganan paket untuk mengakses halaman ini.');
            }
        }

        return $next($request);
    }
}

