<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditService
{
    public function __construct(private readonly TenantContext $tenant) {}

    public function log(string $action, string $resource, int|string|null $resourceId = null, array $metadata = []): AuditLog
    {
        $request = app()->bound('request') ? app(Request::class) : null;
        return AuditLog::create([
            'organization_id' => $this->tenant->id(),
            'user_id' => $request?->user()?->id,
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'metadata' => $metadata,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
