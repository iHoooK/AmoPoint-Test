<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTrackingConsent
{
    public function handle(Request $request, Closure $next): Response
    {
        $cookieName = (string) config('tracker.consent_cookie');

        if ($request->cookie($cookieName) !== 'accepted') {
            return redirect()->route('tracker.consent', [
                'redirect' => $request->getRequestUri(),
            ]);
        }

        return $next($request);
    }
}
