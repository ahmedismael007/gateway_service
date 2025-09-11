<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantFromHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->header('X-Tenant');

        if ($tenantId) {
            try {
                tenancy()->initialize($tenantId);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Invalid tenant identifier.',
                    'error' => $e->getMessage(),
                ], 400);
            }
        }

        return $next($request);
    }
}
