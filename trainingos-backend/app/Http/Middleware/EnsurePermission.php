<?php

namespace App\Http\Middleware;

use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
        $tenant = app(TenantContext::class)->organization();
        abort_unless($user && $user->hasPermission($tenant->id, $permission), 403, 'You do not have permission to perform this action.');
        return $next($request);
    }
}
