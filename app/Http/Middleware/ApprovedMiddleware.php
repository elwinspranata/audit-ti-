<?php

// app/Http/Middleware/ApprovedMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApprovedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->approved == 1) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Your account is not approved yet!');
    }
}
