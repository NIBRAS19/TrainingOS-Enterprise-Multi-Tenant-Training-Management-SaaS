<?php

namespace App\Models\Concerns;

use App\Models\Organization;
use App\Support\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::creating(function ($model) {
            if (empty($model->organization_id) && app()->bound(TenantContext::class)) {
                $model->organization_id = app(TenantContext::class)->id();
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (! app()->bound(TenantContext::class)) return;
            try {
                $builder->where($builder->getModel()->getTable().'.organization_id', app(TenantContext::class)->id());
            } catch (\Throwable) {
                // Allow CLI jobs / migrations to query without a tenant context.
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
