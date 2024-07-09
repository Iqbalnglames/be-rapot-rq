<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null; // No redirection for JSON requests
        }

        return route('login'); // Redirect to login route for non-JSON requests
    }
    
    public function handle($request, $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        // Optional: Regenerate session only if remember_me is present
        if ($request->has('remember')) {
            $request->session()->regenerate(true); // Regenerate with CSRF protection
        }

        return $next($request);
    }
}
