<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Support\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        abort_unless($user, 401);

        $organizationId = (int) ($request->header('X-Organization-Id') ?: $request->user()->active_organization_id);
        abort_if($organizationId <= 0, 422, 'An active organization is required.');

        $membership = $user->organizations()->whereKey($organizationId)->first();
        abort_unless($membership, 403, 'You do not belong to this organization.');

        $organization = Organization::query()->whereKey($organizationId)->where('status', 'active')->first();
        abort_unless($organization, 404, 'Organization not found.');

        app(TenantContext::class)->set($organization);

        return $next($request);
    }
}
