<?php

namespace App\Support;

use App\Models\Organization;
use RuntimeException;

class TenantContext
{
    private ?Organization $organization = null;

    public function set(Organization $organization): void
    {
        $this->organization = $organization;
    }

    public function clear(): void
    {
        $this->organization = null;
    }

    public function id(): int
    {
        if (! $this->organization) {
            throw new RuntimeException('No active organization has been resolved.');
        }

        return $this->organization->id;
    }

    public function organization(): Organization
    {
        if (! $this->organization) {
            throw new RuntimeException('No active organization has been resolved.');
        }

        return $this->organization;
    }
}
