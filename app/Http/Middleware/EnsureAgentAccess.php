<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $configuredApiKey = (string) config('services.agents.api_key', '');
        $providedApiKey = (string) $request->header('X-Agent-Key', '');

        if ($configuredApiKey !== '' && $providedApiKey !== '' && hash_equals($configuredApiKey, $providedApiKey)) {
            return $next($request);
        }

        $user = $request->user();
        if ($user && $user->role === User::ROLE_ADMIN) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized to run agents.',
        ], 401);
    }
}
